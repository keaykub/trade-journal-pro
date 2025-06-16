<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TradeAnalytics extends Component
{
    // Date Range Properties
    public $dateFrom = '';
    public $dateTo = '';

    // Cache properties
    private $tradesCache = null;
    private $analyticsCache = [];

    public function mount()
    {
        // Set default date range to current year
        $this->dateFrom = now()->startOfYear()->format('Y-m-d');
        $this->dateTo = now()->endOfYear()->format('Y-m-d');
    }

    public function updatedDateFrom()
    {
        $this->clearCache();
    }

    public function updatedDateTo()
    {
        $this->clearCache();
    }

    private function clearCache()
    {
        $this->tradesCache = null;
        $this->analyticsCache = [];
    }

    private function getTrades(): Collection
    {
        if ($this->tradesCache === null) {
            $this->tradesCache = Trade::where('user_id', auth()->id())
                ->when($this->dateFrom, function($q) {
                    $q->whereDate('entry_date', '>=', $this->dateFrom);
                })
                ->when($this->dateTo, function($q) {
                    $q->whereDate('entry_date', '<=', $this->dateTo);
                })
                ->orderBy('entry_date', 'asc')
                ->orderBy('entry_time', 'asc')
                ->get();
        }

        return $this->tradesCache;
    }

    private function getAnalytics(): array
    {
        if (empty($this->analyticsCache)) {
            $trades = $this->getTrades();

            if ($trades->isEmpty()) {
                $this->analyticsCache = $this->getEmptyAnalytics();
            } else {
                $this->analyticsCache = $this->calculateAnalytics($trades);
            }
        }

        return $this->analyticsCache;
    }

    private function getEmptyAnalytics(): array
    {
        return [
            'totalTrades' => 0,
            'winTrades' => 0,
            'lossTrades' => 0,
            'breakEvenTrades' => 0,
            'pendingTrades' => 0,
            'winRate' => 0,
            'totalPnl' => 0,
            'grossProfit' => 0,
            'grossLoss' => 0,
            'profitFactor' => 0,
            'averageRiskReward' => 0,
            'equityCurveData' => [],
            'pnlDistribution' => $this->getEmptyPnlDistribution(),
            'strategyUsage' => [],
            'emotionAnalysis' => [],
            'timeAnalysis' => $this->getEmptyTimeAnalysis(),
            'performanceAnalysis' => $this->getEmptyPerformanceAnalysis(),
        ];
    }

    private function calculateAnalytics(Collection $trades): array
    {
        // Calculate all analytics in one pass
        $analytics = [
            'totalTrades' => $trades->count(),
            'winTrades' => 0,
            'lossTrades' => 0,
            'breakEvenTrades' => 0,
            'pendingTrades' => 0,
            'totalPnl' => 0,
            'grossProfit' => 0,
            'grossLoss' => 0,
            'riskRewardSum' => 0,
            'riskRewardCount' => 0,
            'equityCurveData' => [],
            'strategyCounts' => [],
            'emotionCounts' => [],
            'hourlyData' => array_fill(0, 24, ['count' => 0, 'pnl' => 0, 'wins' => 0]),
            'strategyPerformance' => [],
            'symbolPerformance' => [],
        ];

        $runningBalance = 0;

        foreach ($trades as $trade) {
            // Basic counts
            switch ($trade->result) {
                case 'win':
                    $analytics['winTrades']++;
                    break;
                case 'loss':
                    $analytics['lossTrades']++;
                    break;
                case 'breakeven':
                    $analytics['breakEvenTrades']++;
                    break;
                case 'pending':
                    $analytics['pendingTrades']++;
                    break;
            }

            // PnL calculations
            $pnl = $trade->pnl ?? 0;
            $analytics['totalPnl'] += $pnl;

            if ($pnl > 0) {
                $analytics['grossProfit'] += $pnl;
            } else {
                $analytics['grossLoss'] += abs($pnl);
            }

            // Risk Reward
            if (!is_null($trade->risk_reward) && $trade->risk_reward > 0) {
                $analytics['riskRewardSum'] += $trade->risk_reward;
                $analytics['riskRewardCount']++;
            }

            // Equity curve
            $runningBalance += $pnl;
            $analytics['equityCurveData'][] = [
                'date' => $trade->entry_date->format('Y-m-d'),
                'balance' => round($runningBalance, 2)
            ];

            // Strategy usage
            $strategy = $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
            if (!isset($analytics['strategyCounts'][$strategy])) {
                $analytics['strategyCounts'][$strategy] = 0;
            }
            $analytics['strategyCounts'][$strategy]++;

            // Emotion analysis
            if (!is_null($trade->emotion_before)) {
                if (!isset($analytics['emotionCounts'][$trade->emotion_before])) {
                    $analytics['emotionCounts'][$trade->emotion_before] = 0;
                }
                $analytics['emotionCounts'][$trade->emotion_before]++;
            }

            // Time analysis
            if (!is_null($trade->entry_time)) {
                $hour = Carbon::parse($trade->entry_time)->hour;
                $analytics['hourlyData'][$hour]['count']++;
                $analytics['hourlyData'][$hour]['pnl'] += $pnl;
                if ($trade->result === 'win') {
                    $analytics['hourlyData'][$hour]['wins']++;
                }
            }

            // Strategy performance
            if (!isset($analytics['strategyPerformance'][$strategy])) {
                $analytics['strategyPerformance'][$strategy] = [
                    'name' => $strategy,
                    'pnl' => 0,
                    'trades' => 0,
                    'wins' => 0
                ];
            }
            $analytics['strategyPerformance'][$strategy]['pnl'] += $pnl;
            $analytics['strategyPerformance'][$strategy]['trades']++;
            if ($trade->result === 'win') {
                $analytics['strategyPerformance'][$strategy]['wins']++;
            }

            // Symbol performance
            $symbol = $trade->symbol;
            if (!isset($analytics['symbolPerformance'][$symbol])) {
                $analytics['symbolPerformance'][$symbol] = [
                    'name' => $symbol,
                    'pnl' => 0,
                    'trades' => 0,
                    'wins' => 0
                ];
            }
            $analytics['symbolPerformance'][$symbol]['pnl'] += $pnl;
            $analytics['symbolPerformance'][$symbol]['trades']++;
            if ($trade->result === 'win') {
                $analytics['symbolPerformance'][$symbol]['wins']++;
            }
        }

        // Calculate derived values
        return $this->calculateDerivedAnalytics($analytics);
    }

    private function calculateDerivedAnalytics(array $analytics): array
    {
        // Win rate
        $analytics['winRate'] = $analytics['totalTrades'] > 0
            ? round(($analytics['winTrades'] / $analytics['totalTrades']) * 100, 1)
            : 0;

        // Profit factor
        $analytics['profitFactor'] = $analytics['grossLoss'] > 0
            ? round($analytics['grossProfit'] / $analytics['grossLoss'], 2)
            : ($analytics['grossProfit'] > 0 ? 999 : 0);

        // Average risk reward
        $analytics['averageRiskReward'] = $analytics['riskRewardCount'] > 0
            ? round($analytics['riskRewardSum'] / $analytics['riskRewardCount'], 2)
            : 0;

        // Format PnL distribution
        $analytics['pnlDistribution'] = [
            ['label' => 'Win', 'value' => $analytics['winTrades'], 'color' => '#10b981'],
            ['label' => 'Loss', 'value' => $analytics['lossTrades'], 'color' => '#ef4444'],
            ['label' => 'Break Even', 'value' => $analytics['breakEvenTrades'], 'color' => '#f59e0b'],
            ['label' => 'Pending', 'value' => $analytics['pendingTrades'], 'color' => '#6b7280']
        ];

        // Format strategy usage
        arsort($analytics['strategyCounts']);
        $analytics['strategyUsage'] = [];
        foreach (array_slice($analytics['strategyCounts'], 0, 10, true) as $strategy => $count) {
            $analytics['strategyUsage'][] = [
                'strategy' => ucfirst($strategy ?? 'Unknown'),
                'count' => $count
            ];
        }

        // Format emotion analysis
        arsort($analytics['emotionCounts']);
        $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#84cc16'];
        $analytics['emotionAnalysis'] = [];
        $colorIndex = 0;

        foreach (array_slice($analytics['emotionCounts'], 0, 8, true) as $emotion => $count) {
            $analytics['emotionAnalysis'][] = [
                'label' => ucfirst($emotion),
                'value' => $count,
                'color' => $colors[$colorIndex % count($colors)]
            ];
            $colorIndex++;
        }

        // Format time analysis
        $analytics['timeAnalysis'] = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $data = $analytics['hourlyData'][$hour];
            $winRate = $data['count'] > 0 ? round(($data['wins'] / $data['count']) * 100, 1) : 0;

            $analytics['timeAnalysis'][] = [
                'hour' => sprintf('%02d:00', $hour),
                'trades' => $data['count'],
                'pnl' => round($data['pnl'], 2),
                'winRate' => $winRate
            ];
        }

        // Format performance analysis
        $analytics['performanceAnalysis'] = $this->formatPerformanceAnalysis($analytics);

        return $analytics;
    }

    private function formatPerformanceAnalysis(array $analytics): array
    {
        // Calculate win rates for strategies and symbols
        foreach ($analytics['strategyPerformance'] as &$strategy) {
            $strategy['winRate'] = $strategy['trades'] > 0
                ? round(($strategy['wins'] / $strategy['trades']) * 100, 1)
                : 0;
        }

        foreach ($analytics['symbolPerformance'] as &$symbol) {
            $symbol['winRate'] = $symbol['trades'] > 0
                ? round(($symbol['wins'] / $symbol['trades']) * 100, 1)
                : 0;
        }

        // Sort by PnL
        uasort($analytics['strategyPerformance'], fn($a, $b) => $b['pnl'] <=> $a['pnl']);
        uasort($analytics['symbolPerformance'], fn($a, $b) => $b['pnl'] <=> $a['pnl']);

        return [
            'bestStrategy' => reset($analytics['strategyPerformance']) ?: null,
            'bestSymbol' => reset($analytics['symbolPerformance']) ?: null,
            'worstStrategy' => end($analytics['strategyPerformance']) ?: null,
            'worstSymbol' => end($analytics['symbolPerformance']) ?: null,
        ];
    }

    private function getEmptyPnlDistribution(): array
    {
        return [
            ['label' => 'Win', 'value' => 0, 'color' => '#10b981'],
            ['label' => 'Loss', 'value' => 0, 'color' => '#ef4444'],
            ['label' => 'Break Even', 'value' => 0, 'color' => '#f59e0b'],
            ['label' => 'Pending', 'value' => 0, 'color' => '#6b7280']
        ];
    }

    private function getEmptyTimeAnalysis(): array
    {
        $timeAnalysis = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $timeAnalysis[] = [
                'hour' => sprintf('%02d:00', $hour),
                'trades' => 0,
                'pnl' => 0,
                'winRate' => 0
            ];
        }
        return $timeAnalysis;
    }

    private function getEmptyPerformanceAnalysis(): array
    {
        return [
            'bestStrategy' => null,
            'bestSymbol' => null,
            'worstStrategy' => null,
            'worstSymbol' => null,
        ];
    }

    // Property accessors (using cached data)
    public function getTotalTradesProperty()
    {
        return $this->getAnalytics()['totalTrades'];
    }

    public function getWinRateProperty()
    {
        return $this->getAnalytics()['winRate'];
    }

    public function getTotalPnlProperty()
    {
        return $this->getAnalytics()['totalPnl'];
    }

    public function getAverageRiskRewardProperty()
    {
        return $this->getAnalytics()['averageRiskReward'];
    }

    public function getProfitFactorProperty()
    {
        return $this->getAnalytics()['profitFactor'];
    }

    public function getEquityCurveDataProperty()
    {
        return $this->getAnalytics()['equityCurveData'];
    }

    public function getPnlDistributionProperty()
    {
        return $this->getAnalytics()['pnlDistribution'];
    }

    public function getStrategyUsageProperty()
    {
        return $this->getAnalytics()['strategyUsage'];
    }

    public function getEmotionAnalysisProperty()
    {
        return $this->getAnalytics()['emotionAnalysis'];
    }

    public function getTimeAnalysisProperty()
    {
        return $this->getAnalytics()['timeAnalysis'];
    }

    public function getPerformanceAnalysisProperty()
    {
        return $this->getAnalytics()['performanceAnalysis'];
    }

    public function render()
    {
        view()->share([
            'title' => 'สถิติการเทรด',
            'description' => 'วิเคราะห์ผลการเทรดและประสิทธิภาพของคุณ'
        ]);

        $analytics = $this->getAnalytics();

        return view('livewire.trade-analytics', [
            'totalTrades' => $analytics['totalTrades'],
            'winRate' => $analytics['winRate'],
            'totalPnl' => $analytics['totalPnl'],
            'averageRiskReward' => $analytics['averageRiskReward'],
            'profitFactor' => $analytics['profitFactor'],
            'equityCurveData' => $analytics['equityCurveData'],
            'pnlDistribution' => $analytics['pnlDistribution'],
            'strategyUsage' => $analytics['strategyUsage'],
            'emotionAnalysis' => $analytics['emotionAnalysis'],
            'timeAnalysis' => $analytics['timeAnalysis'],
            'performanceAnalysis' => $analytics['performanceAnalysis'],
        ])->layout('layouts.main');
    }
}

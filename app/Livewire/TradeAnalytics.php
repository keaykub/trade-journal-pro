<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Trade;
use Carbon\Carbon;

class TradeAnalytics extends Component
{
    // Date Range Properties
    public $dateFrom = '';
    public $dateTo = '';

    public function mount()
    {
        // Set default date range to current year
        $this->dateFrom = now()->startOfYear()->format('Y-m-d');
        $this->dateTo = now()->endOfYear()->format('Y-m-d');
    }

    public function updatedDateFrom()
    {
        // Auto refresh when date changes
    }

    public function updatedDateTo()
    {
        // Auto refresh when date changes
    }

    // Basic Stats Methods
    public function getTotalTradesProperty()
    {
        return $this->getBaseQuery()->count();
    }

    public function getWinRateProperty()
    {
        $totalTrades = $this->totalTrades;
        if ($totalTrades == 0) return 0;

        $winTrades = $this->getBaseQuery()->where('result', 'win')->count();
        return round(($winTrades / $totalTrades) * 100, 1);
    }

    public function getTotalPnlProperty()
    {
        return $this->getBaseQuery()->sum('pnl') ?? 0;
    }

    public function getAverageRiskRewardProperty()
    {
        $avgRR = $this->getBaseQuery()
            ->whereNotNull('risk_reward')
            ->where('risk_reward', '>', 0)
            ->avg('risk_reward');

        return $avgRR ? round($avgRR, 2) : 0;
    }

    public function getProfitFactorProperty()
    {
        $grossProfit = $this->getBaseQuery()->where('pnl', '>', 0)->sum('pnl') ?? 0;
        $grossLoss = abs($this->getBaseQuery()->where('pnl', '<', 0)->sum('pnl')) ?? 0;

        return $grossLoss > 0 ? round($grossProfit / $grossLoss, 2) : ($grossProfit > 0 ? 999 : 0);
    }

    // Chart Data Methods
    public function getEquityCurveDataProperty()
    {
        $trades = $this->getBaseQuery()
            ->orderBy('entry_date', 'asc')
            ->orderBy('entry_time', 'asc')
            ->get();

        $equityData = [];
        $runningBalance = 0;

        foreach ($trades as $trade) {
            $runningBalance += $trade->pnl ?? 0;
            $equityData[] = [
                'date' => $trade->entry_date->format('Y-m-d'),
                'balance' => round($runningBalance, 2)
            ];
        }

        return $equityData;
    }

    public function getPnlDistributionProperty()
    {
        $winTrades = $this->getBaseQuery()->where('result', 'win')->count();
        $lossTrades = $this->getBaseQuery()->where('result', 'loss')->count();
        $breakEvenTrades = $this->getBaseQuery()->where('result', 'breakeven')->count();
        $pendingTrades = $this->getBaseQuery()->where('result', 'pending')->count();

        return [
            ['label' => 'Win', 'value' => $winTrades, 'color' => '#10b981'],
            ['label' => 'Loss', 'value' => $lossTrades, 'color' => '#ef4444'],
            ['label' => 'Break Even', 'value' => $breakEvenTrades, 'color' => '#f59e0b'],
            ['label' => 'Pending', 'value' => $pendingTrades, 'color' => '#6b7280']
        ];
    }

    public function getStrategyUsageProperty()
    {
        $strategies = $this->getBaseQuery()
            ->get()
            ->groupBy(function($trade) {
                return $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
            })
            ->map(function($group) {
                return $group->count();
            })
            ->sortDesc()
            ->take(10);

        $chartData = [];
        foreach ($strategies as $strategy => $count) {
            $chartData[] = [
                'strategy' => ucfirst($strategy ?? 'Unknown'),
                'count' => $count
            ];
        }

        return $chartData;
    }

    public function getEmotionAnalysisProperty()
    {
        $emotions = $this->getBaseQuery()
            ->whereNotNull('emotion_before')
            ->get()
            ->groupBy('emotion_before')
            ->map(function($group) {
                return $group->count();
            })
            ->sortDesc()
            ->take(8);

        $chartData = [];
        $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#84cc16'];
        $colorIndex = 0;

        foreach ($emotions as $emotion => $count) {
            $chartData[] = [
                'label' => ucfirst($emotion),
                'value' => $count,
                'color' => $colors[$colorIndex % count($colors)]
            ];
            $colorIndex++;
        }

        return $chartData;
    }

    public function getTimeAnalysisProperty()
    {
        $hourlyData = $this->getBaseQuery()
            ->whereNotNull('entry_time')
            ->get()
            ->groupBy(function($trade) {
                return Carbon::parse($trade->entry_time)->hour;
            })
            ->map(function($group) {
                return [
                    'count' => $group->count(),
                    'pnl' => $group->sum('pnl'),
                    'winRate' => $group->where('result', 'win')->count() / $group->count() * 100
                ];
            })
            ->sortKeys();

        $chartData = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $data = $hourlyData->get($hour, ['count' => 0, 'pnl' => 0, 'winRate' => 0]);
            $chartData[] = [
                'hour' => sprintf('%02d:00', $hour),
                'trades' => $data['count'],
                'pnl' => round($data['pnl'], 2),
                'winRate' => round($data['winRate'], 1)
            ];
        }

        return $chartData;
    }

    public function getPerformanceAnalysisProperty()
    {
        // Best Strategy
        $bestStrategyData = $this->getBaseQuery()
            ->get()
            ->groupBy(function($trade) {
                return $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
            })
            ->map(function($group, $strategyName) {
                return [
                    'name' => $strategyName,
                    'pnl' => $group->sum('pnl'),
                    'trades' => $group->count(),
                    'winRate' => $group->where('result', 'win')->count() / $group->count() * 100
                ];
            })
            ->sortByDesc('pnl')
            ->first();

        // Best Symbol
        $bestSymbolData = $this->getBaseQuery()
            ->get()
            ->groupBy('symbol')
            ->map(function($group, $symbolName) {
                return [
                    'name' => $symbolName,
                    'pnl' => $group->sum('pnl'),
                    'trades' => $group->count(),
                    'winRate' => $group->where('result', 'win')->count() / $group->count() * 100
                ];
            })
            ->sortByDesc('pnl')
            ->first();

        // Worst Strategy
        $worstStrategyData = $this->getBaseQuery()
            ->get()
            ->groupBy(function($trade) {
                return $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
            })
            ->map(function($group, $strategyName) {
                return [
                    'name' => $strategyName,
                    'pnl' => $group->sum('pnl'),
                    'trades' => $group->count(),
                    'winRate' => $group->where('result', 'win')->count() / $group->count() * 100
                ];
            })
            ->sortBy('pnl')
            ->first();

        // Worst Symbol
        $worstSymbolData = $this->getBaseQuery()
            ->get()
            ->groupBy('symbol')
            ->map(function($group, $symbolName) {
                return [
                    'name' => $symbolName,
                    'pnl' => $group->sum('pnl'),
                    'trades' => $group->count(),
                    'winRate' => $group->where('result', 'win')->count() / $group->count() * 100
                ];
            })
            ->sortBy('pnl')
            ->first();

        return [
            'bestStrategy' => $bestStrategyData,
            'bestSymbol' => $bestSymbolData,
            'worstStrategy' => $worstStrategyData,
            'worstSymbol' => $worstSymbolData
        ];
    }

    private function getBaseQuery()
    {
        return Trade::where('user_id', auth()->id())
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            });
    }

    public function render()
    {
        view()->share([
            'title' => 'สถิติการเทรด',
            'description' => 'วิเคราะห์ผลการเทรดและประสิทธิภาพของคุณ'
        ]);

        return view('livewire.trade-analytics', [
            'totalTrades' => $this->totalTrades,
            'winRate' => $this->winRate,
            'totalPnl' => $this->totalPnl,
            'averageRiskReward' => $this->averageRiskReward,
            'profitFactor' => $this->profitFactor,
            'equityCurveData' => $this->equityCurveData,
            'pnlDistribution' => $this->pnlDistribution,
            'strategyUsage' => $this->strategyUsage,
            'emotionAnalysis' => $this->emotionAnalysis,
            'timeAnalysis' => $this->timeAnalysis,
            'performanceAnalysis' => $this->performanceAnalysis,
        ])->layout('layouts.main');
    }
}

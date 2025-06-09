<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Trade;
use Carbon\Carbon;

class Dashboard extends Component
{
    use WithPagination;

    // Search and Filter Properties
    public $search = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $statusFilter = '';
    public $strategyFilter = '';

    public $showShareModal = false;             //new
    public $shareUrl = '';                      //new
    public $sharingTradeId = null;              //new

    // Pagination
    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        // Set default date range to current month
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->endOfMonth()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedStrategyFilter()
    {
        $this->resetPage();
    }

    public function shareTrade($tradeId)
    {
        $trade = Trade::where('id', $tradeId)
                     ->where('user_id', auth()->id())
                     ->firstOrFail();

        // เปิดการแชร์
        $trade->update(['is_shared' => true]);

        // เก็บข้อมูลสำหรับ modal
        $this->sharingTradeId = $tradeId;
        $this->shareUrl = route('trades.public', $trade->id);
        $this->showShareModal = true;

        // แจ้งเตือน
        session()->flash('success', 'Trade shared successfully!');
    }

    public function closeShareModal()
    {
        $this->showShareModal = false;
        $this->shareUrl = '';
        $this->sharingTradeId = null;
    }

    // Method สำหรับยกเลิกการแชร์
    public function unshareTrade($tradeId)
    {
        $trade = Trade::where('id', $tradeId)
                     ->where('user_id', auth()->id())
                     ->firstOrFail();

        $trade->update(['is_shared' => false]);

        session()->flash('info', 'Trade unshared successfully!');
    }
    public function resetFilters()
    {
        $this->search = '';
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->endOfMonth()->format('Y-m-d');
        $this->statusFilter = '';
        $this->strategyFilter = '';
        $this->resetPage();
    }

    public function exportTrades()
    {
        // TODO: Implement export functionality
        session()->flash('info', 'Export feature coming soon!');
    }

    public function deleteTrade($tradeId)
    {
        try {
            $trade = Trade::where('user_id', auth()->id())->findOrFail($tradeId);
            $trade->delete();

            session()->flash('success', 'ลบการเทรดเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            session()->flash('error', 'เกิดข้อผิดพลาดในการลบข้อมูล');
        }
    }

    public function getTradesProperty()
    {
        $query = Trade::where('user_id', auth()->id())
            ->when($this->search, function($q) {
                $q->where(function($query) {
                    $search = $this->search;
                    // ค้นหาใน symbol, strategy, และ custom_strategy
                    $query->where('symbol', 'like', '%' . $search . '%')
                          ->orWhere('strategy', 'like', '%' . $search . '%')
                          ->orWhere('custom_strategy', 'like', '%' . $search . '%');
                });
            })
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            })
            ->when($this->statusFilter, function($q) {
                $q->where('result', $this->statusFilter);
            })
            ->when($this->strategyFilter, function($q) {
                // Filter โดยพิจารณาทั้ง strategy และ custom_strategy
                $q->where(function($query) {
                    $strategy = $this->strategyFilter;
                    $query->where('strategy', $strategy)
                          ->orWhere('custom_strategy', $strategy);
                });
            })
            ->orderBy('entry_date', 'desc')
            ->orderBy('entry_time', 'desc');

        return $query->paginate(5);
    }

    // Stats Methods (UI only for now)
    public function getTotalTradesProperty()
    {
        return Trade::where('user_id', auth()->id())
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            })
            ->count();
    }

    public function getWinRateProperty()
    {
        $totalTrades = $this->totalTrades;
        if ($totalTrades == 0) return 0;

        $winTrades = Trade::where('user_id', auth()->id())
            ->where('result', 'win')
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            })
            ->count();

        return round(($winTrades / $totalTrades) * 100, 1);
    }

    public function getTotalPnlProperty()
    {
        return Trade::where('user_id', auth()->id())
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            })
            ->sum('pnl') ?? 0;
    }

    public function getBestStrategyProperty()
    {
        $trades = Trade::where('user_id', auth()->id())
            ->when($this->dateFrom, function($q) {
                $q->whereDate('entry_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function($q) {
                $q->whereDate('entry_date', '<=', $this->dateTo);
            })
            ->get();

        // Group by final strategy (use custom_strategy if strategy is 'other')
        $strategies = $trades->groupBy(function($trade) {
            return $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
        })->map(function($group) {
            return $group->sum('pnl');
        })->sortDesc();

        return $strategies->keys()->first() ?? 'N/A';
    }

    public function getUniqueStrategiesProperty()
    {
        $trades = Trade::where('user_id', auth()->id())
            ->whereNotNull('strategy')
            ->get();

        // Collect all unique strategies (use custom_strategy if strategy is 'other')
        $strategies = $trades->map(function($trade) {
            return $trade->strategy === 'other' ? $trade->custom_strategy : $trade->strategy;
        })->filter()->unique()->values()->toArray();

        return $strategies;
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'trades' => $this->trades,
            'totalTrades' => $this->totalTrades,
            'winRate' => $this->winRate,
            'totalPnl' => $this->totalPnl,
            'bestStrategy' => $this->bestStrategy,
            'uniqueStrategies' => $this->uniqueStrategies,
        ])->layout('layouts.main');
    }
}

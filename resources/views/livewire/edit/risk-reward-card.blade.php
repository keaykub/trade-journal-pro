{{-- resources/views/trades/partials/analysis/risk-reward-card.blade.php --}}
<div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/50 dark:border-slate-700/50 hover:shadow-lg transition-all duration-300">
    <div class="flex items-center justify-between mb-3">
        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Risk : Reward</span>
        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
            <i class="fas fa-balance-scale text-blue-600 dark:text-blue-400 text-sm"></i>
        </div>
    </div>
    <div class="text-3xl font-bold text-blue-500">
        {{ $this->riskReward ?? '---' }}
    </div>
    <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
        @if($this->riskReward && $this->riskReward >= 3)
            <span class="text-green-500 font-medium">Excellent ratio</span>
        @elseif($this->riskReward && $this->riskReward >= 2)
            <span class="text-blue-500 font-medium">Very good ratio</span>
        @elseif($this->riskReward && $this->riskReward >= 1)
            <span class="text-yellow-500 font-medium">Good ratio</span>
        @elseif($this->riskReward && $this->riskReward < 1)
            <span class="text-red-500 font-medium">Poor ratio</span>
        @else
            <span class="text-slate-400">Needs data</span>
        @endif
    </div>
</div>

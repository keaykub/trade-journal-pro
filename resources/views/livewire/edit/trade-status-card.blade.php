{{-- resources/views/trades/partials/analysis/trade-status-card.blade.php --}}
<div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/50 dark:border-slate-700/50 hover:shadow-lg transition-all duration-300">
    <div class="flex items-center justify-between mb-3">
        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Trade Status</span>
        <div class="flex items-center space-x-2">
            {{-- Toggle Button for Manual Selection --}}
            <button type="button" wire:click="$toggle('manualResult')"
                class="text-xs px-2 py-1 rounded-lg transition-all duration-200 {{ $manualResult ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-400 dark:hover:bg-slate-600' }}">
                <i class="fas fa-edit mr-1"></i>{{ $manualResult ? 'Auto' : 'Manual' }}
            </button>

            <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ ($manualResult ? $manualResultValue : $this->result) === 'win' ? 'bg-emerald-100 dark:bg-emerald-900/30' : (($manualResult ? $manualResultValue : $this->result) === 'loss' ? 'bg-red-100 dark:bg-red-900/30' : (($manualResult ? $manualResultValue : $this->result) === 'breakeven' ? 'bg-yellow-100 dark:bg-yellow-900/30' : 'bg-slate-100 dark:bg-slate-700')) }}">
                @php
                    $currentResult = $manualResult ? $manualResultValue : $this->result;
                @endphp
                @if($currentResult === 'win')
                    <i class="fas fa-trophy text-emerald-600 dark:text-emerald-400 text-sm"></i>
                @elseif($currentResult === 'loss')
                    <i class="fas fa-chart-line-down text-red-600 dark:text-red-400 text-sm"></i>
                @elseif($currentResult === 'breakeven')
                    <i class="fas fa-equals text-yellow-600 dark:text-yellow-400 text-sm"></i>
                @else
                    <i class="fas fa-clock text-slate-500 text-sm"></i>
                @endif
            </div>
        </div>
    </div>

    @if($manualResult)
        {{-- Manual Selection Mode --}}
        <div class="space-y-3">
            <div class="flex items-center space-x-2">
                <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">
                    <i class="fas fa-hand-point-right mr-1"></i>Manual Selection
                </span>
            </div>

            {{-- Status Selection Buttons --}}
            <div class="grid grid-cols-2 gap-2">
                {{-- Win Button --}}
                <button type="button" wire:click="$set('manualResultValue', 'win')"
                    class="p-3 rounded-xl border-2 transition-all duration-300 text-center hover:scale-105 {{ $manualResultValue === 'win' ? 'bg-gradient-to-r from-emerald-500 to-green-500 border-emerald-600 text-white shadow-lg shadow-emerald-500/25' : 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' }}">
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-trophy text-sm"></i>
                        <span class="font-semibold">Win</span>
                    </div>
                </button>

                {{-- Loss Button --}}
                <button type="button" wire:click="$set('manualResultValue', 'loss')"
                    class="p-3 rounded-xl border-2 transition-all duration-300 text-center hover:scale-105 {{ $manualResultValue === 'loss' ? 'bg-gradient-to-r from-red-500 to-rose-500 border-red-600 text-white shadow-lg shadow-red-500/25' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-chart-line-down text-sm"></i>
                        <span class="font-semibold">Loss</span>
                    </div>
                </button>

                {{-- Break Even Button --}}
                <button type="button" wire:click="$set('manualResultValue', 'breakeven')"
                    class="p-3 rounded-xl border-2 transition-all duration-300 text-center hover:scale-105 {{ $manualResultValue === 'breakeven' ? 'bg-gradient-to-r from-yellow-500 to-amber-500 border-yellow-600 text-white shadow-lg shadow-yellow-500/25' : 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 hover:bg-yellow-100 dark:hover:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' }}">
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-equals text-sm"></i>
                        <span class="font-semibold">Break Even</span>
                    </div>
                </button>

                {{-- Pending Button --}}
                <button type="button" wire:click="$set('manualResultValue', 'pending')"
                    class="p-3 rounded-xl border-2 transition-all duration-300 text-center hover:scale-105 {{ $manualResultValue === 'pending' ? 'bg-gradient-to-r from-slate-500 to-gray-500 border-slate-600 text-white shadow-lg shadow-slate-500/25' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300' }}">
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-clock text-sm"></i>
                        <span class="font-semibold">Pending</span>
                    </div>
                </button>
            </div>
        </div>
    @else
        {{-- Auto Calculation Mode --}}
        <div class="text-3xl font-bold {{ $this->result === 'win' ? 'text-emerald-500' : ($this->result === 'loss' ? 'text-red-500' : ($this->result === 'breakeven' ? 'text-yellow-500' : 'text-slate-500')) }}">
            @if($this->result === 'win')
                Win
            @elseif($this->result === 'loss')
                Loss
            @elseif($this->result === 'breakeven')
                Break Even
            @else
                Pending
            @endif
        </div>
        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            {{ $this->result === 'win' ? 'Target achieved!' : ($this->result === 'loss' ? 'Stop loss hit' : ($this->result === 'breakeven' ? 'No profit/loss' : 'Awaiting calculation')) }}
        </div>

        {{-- Auto calculation hint --}}
        @if($this->result && $this->result !== 'pending')
            <div class="mt-2 text-xs text-slate-400 flex items-center">
                <i class="fas fa-calculator mr-1"></i>
                Auto-calculated from P&L
            </div>
        @endif
    @endif

    {{-- Display current selection in manual mode --}}
    @if($manualResult && $manualResultValue)
        <div class="mt-3 text-xs text-slate-500 dark:text-slate-400">
            {{ $manualResultValue === 'win' ? 'Profitable trade!' : ($manualResultValue === 'loss' ? 'Learning experience' : ($manualResultValue === 'breakeven' ? 'No profit/loss' : 'Trade in progress')) }}
        </div>
    @endif
</div>

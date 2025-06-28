{{-- resources/views/components/trade-form/analysis/pnl-card.blade.php --}}
<div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/50 dark:border-slate-700/50 hover:shadow-lg transition-all duration-300">
    <div class="flex items-center justify-between mb-3">
        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Profit & Loss</span>
        <div class="flex items-center space-x-2">
            {{-- Toggle Button for Manual Input --}}
            <button type="button" wire:click="$toggle('manualPnl')"
                class="text-xs px-2 py-1 rounded-lg transition-all duration-200 {{ $manualPnl ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-400 dark:hover:bg-slate-600' }}">
                <i class="fas fa-edit mr-1"></i>{{ $manualPnl ? 'Auto' : 'Manual' }}
            </button>

            <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ $this->finalPnl > 0 ? 'bg-emerald-100 dark:bg-emerald-900/30' : ($this->finalPnl < 0 ? 'bg-red-100 dark:bg-red-900/30' : 'bg-slate-100 dark:bg-slate-700') }}">
                <i class="fas fa-dollar-sign text-sm {{ $this->finalPnl > 0 ? 'text-emerald-600 dark:text-emerald-400' : ($this->finalPnl < 0 ? 'text-red-600 dark:text-red-400' : 'text-slate-500') }}"></i>
            </div>
        </div>
    </div>

    @if($manualPnl)
        {{-- Manual Input Mode --}}
        <div class="space-y-3">
            <div class="flex items-center space-x-2">
                <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">
                    <i class="fas fa-hand-point-right mr-1"></i>Manual Input
                </span>
            </div>

            <div class="relative">
                <input type="number"
                    step="0.01"
                    min="-999999"
                    max="999999"
                    wire:model.live="manualPnlValue"
                    placeholder="0.00"
                    class="w-full px-3 py-2 text-2xl font-bold bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-center">
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none">
                    <span class="text-lg font-bold">$</span>
                </div>
            </div>

            {{-- Validation Error --}}
            @error('manualPnlValue')
                <div class="text-xs text-red-500 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-lg">
                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                </div>
            @enderror

            {{-- Range Info --}}
            <div class="text-xs text-slate-500 text-center">
                Range: -$999,999 to $999,999
            </div>

            {{-- Display Result --}}
            @if($manualPnlValue != 0)
                <div class="relative min-w-0">
                    <div class="flex items-center justify-center space-x-1 {{ $manualPnlValue > 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        <i class="fas fa-{{ $manualPnlValue > 0 ? 'arrow-up' : 'arrow-down' }} text-sm"></i>
                        <span class="text-lg font-bold truncate {{ $this->isPnlAbbreviated ? 'cursor-help' : '' }}"
                            @if($this->isPnlAbbreviated)
                            title="Full amount: ${{ $this->fullFormattedPnl }}"
                            @endif>
                            ${{ $this->formattedPnl }}
                        </span>
                        <span class="text-xs font-medium">{{ $manualPnlValue > 0 ? 'Profit' : 'Loss' }}</span>
                    </div>
                </div>
            @endif
        </div>
    @else
        {{-- Auto Calculation Mode --}}
        <div class="space-y-2">
            <div class="flex items-center space-x-3 min-w-0">
                <div class="flex-1 min-w-0">
                    <div class="text-3xl sm:text-2xl font-bold {{ $this->pnl > 0 ? 'text-emerald-500' : ($this->pnl < 0 ? 'text-red-500' : 'text-slate-500') }} truncate {{ $this->isPnlAbbreviated ? 'cursor-help' : '' }}"
                        @if($this->isPnlAbbreviated)
                        title="Full amount: ${{ $this->fullFormattedPnl }}"
                        @endif>
                        {{ $this->pnl > 0 ? '+' : '' }}${{ $this->formattedPnl }}
                    </div>
                </div>

                <div class="flex-shrink-0">
                    @if($this->pnl > 0)
                        <div class="flex items-center space-x-1 text-emerald-500">
                            <i class="fas fa-arrow-up text-sm"></i>
                            <span class="text-xs font-medium">Profit</span>
                        </div>
                    @elseif($this->pnl < 0)
                        <div class="flex items-center space-x-1 text-red-500">
                            <i class="fas fa-arrow-down text-sm"></i>
                            <span class="text-xs font-medium">Loss</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-1 text-slate-500">
                            <i class="fas fa-minus text-sm"></i>
                            <span class="text-xs font-medium">Pending</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Auto calculation hint --}}
            @if($this->pnl != 0)
                <div class="text-xs text-slate-400 flex items-center">
                    <i class="fas fa-calculator mr-1"></i>
                    Auto-calculated from trade data
                </div>
            @endif
        </div>
    @endif

    {{-- Percentage Display (if available) --}}
    @if($this->pnlPercentage != 0)
        <div class="mt-3 pt-3 border-t border-slate-200/50 dark:border-slate-700/50">
            <div class="flex items-center justify-between text-sm">
                <span class="text-slate-500">Percentage:</span>
                <span class="font-semibold {{ $this->pnlPercentage > 0 ? 'text-emerald-500' : 'text-red-500' }}">
                    {{ $this->pnlPercentage > 0 ? '+' : '' }}{{ $this->pnlPercentage }}%
                </span>
            </div>
        </div>
    @endif
</div>

{{-- resources/views/components/trade-form/analysis/risk-reward-card.blade.php --}}
<div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-200/50 dark:border-slate-700/50 hover:shadow-lg transition-all duration-300">
    <div class="flex items-center justify-between mb-3">
        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Risk : Reward</span>
        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
            <i class="fas fa-balance-scale text-blue-600 dark:text-blue-400 text-sm"></i>
        </div>
    </div>

    <div class="text-3xl font-bold text-blue-500 mb-2">
        {{ $this->riskReward ?? '---' }}
    </div>

    <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
        @if($this->riskReward && $this->riskReward >= 3)
            <span class="text-green-500 font-medium flex items-center">
                <i class="fas fa-star mr-1"></i>Excellent ratio
            </span>
        @elseif($this->riskReward && $this->riskReward >= 2)
            <span class="text-blue-500 font-medium flex items-center">
                <i class="fas fa-thumbs-up mr-1"></i>Very good ratio
            </span>
        @elseif($this->riskReward && $this->riskReward >= 1)
            <span class="text-yellow-500 font-medium flex items-center">
                <i class="fas fa-check mr-1"></i>Good ratio
            </span>
        @elseif($this->riskReward && $this->riskReward < 1)
            <span class="text-red-500 font-medium flex items-center">
                <i class="fas fa-exclamation-triangle mr-1"></i>Poor ratio
            </span>
        @else
            <span class="text-slate-400 flex items-center">
                <i class="fas fa-info-circle mr-1"></i>Needs SL & TP data
            </span>
        @endif
    </div>

    {{-- Additional Info for Risk Management --}}
    @if($this->riskReward)
        <div class="mt-3 pt-3 border-t border-slate-200/50 dark:border-slate-700/50">
            <div class="text-xs space-y-1">
                @if($this->stopLoss && $this->takeProfit && $this->entryPrice)
                    <div class="flex justify-between">
                        <span class="text-slate-500">Risk:</span>
                        <span class="font-medium text-red-600 dark:text-red-400">
                            {{ abs(round(($this->entryPrice - $this->stopLoss) / $this->entryPrice * 100, 2)) }}%
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Reward:</span>
                        <span class="font-medium text-green-600 dark:text-green-400">
                            {{ abs(round(($this->takeProfit - $this->entryPrice) / $this->entryPrice * 100, 2)) }}%
                        </span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Guidance Messages --}}
    <div class="mt-3 text-xs">
        @if(!$this->stopLoss || !$this->takeProfit)
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-2 text-amber-700 dark:text-amber-300">
                <i class="fas fa-lightbulb mr-1"></i>
                กรอก Stop Loss และ Take Profit เพื่อคำนวณ Risk:Reward
            </div>
        @elseif($this->riskReward && $this->riskReward < 1)
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-2 text-red-700 dark:text-red-300">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                อัตราส่วนต่ำ ควรปรับ SL หรือ TP
            </div>
        @elseif($this->riskReward && $this->riskReward >= 2)
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-2 text-green-700 dark:text-green-300">
                <i class="fas fa-check-circle mr-1"></i>
                อัตราส่วนดี เหมาะสำหรับเทรด
            </div>
        @endif
    </div>
</div>

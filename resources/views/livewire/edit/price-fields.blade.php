{{-- resources/views/trades/partials/fields/price-fields.blade.php --}}
{{-- Entry Price --}}
<div class="group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-play text-emerald-600 dark:text-emerald-400 text-sm"></i>
        </div>
        Entry Price
        <span class="text-red-500 ml-2 font-bold">*</span>
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Required</div>
    </label>
    <div class="relative">
        <input type="number" step="0.00001" wire:model.live="entryPrice" required
            placeholder="1.08542"
            class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-lg shadow-sm hover:shadow-md pl-12"/>
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
            <i class="fas fa-dollar-sign text-sm"></i>
        </div>
    </div>
    @error('entryPrice')
    <div class="mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-700 dark:text-red-400 text-sm flex items-center">
        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
    </div>
    @enderror
    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ราคาที่เปิดโพซิชัน</p>
</div>

{{-- Exit Price --}}
<div class="group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-stop text-red-600 dark:text-red-400 text-sm"></i>
        </div>
        Exit Price
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Optional</div>
    </label>
    <div class="relative">
        <input type="number" step="0.00001" wire:model.live="exitPrice"
            placeholder="1.08642"
            class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-lg shadow-sm hover:shadow-md pl-12"/>
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
            <i class="fas fa-dollar-sign text-sm"></i>
        </div>
    </div>
    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ราคาที่ปิดโพซิชัน (ถ้ายังไม่ปิดสามารถข้ามได้)</p>
</div>

{{-- Stop Loss --}}
<div class="group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-shield-alt text-red-600 dark:text-red-400 text-sm"></i>
        </div>
        Stop Loss
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Risk Management</div>
    </label>
    <div class="relative">
        <input type="number" step="0.00001" wire:model.live="stopLoss"
            placeholder="1.08442"
            class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-lg shadow-sm hover:shadow-md pl-12"/>
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
            <i class="fas fa-shield text-sm"></i>
        </div>
    </div>
    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ระดับการตัดขาดทุน (สำหรับคำนวณ Risk:Reward)</p>
</div>

{{-- Take Profit --}}
<div class="group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-bullseye text-emerald-600 dark:text-emerald-400 text-sm"></i>
        </div>
        Take Profit
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Target</div>
    </label>
    <div class="relative">
        <input type="number" step="0.00001" wire:model.live="takeProfit"
            placeholder="1.08742"
            class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-lg shadow-sm hover:shadow-md pl-12"/>
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
            <i class="fas fa-target text-sm"></i>
        </div>
    </div>
    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">เป้าหมายการทำกำไร (สำหรับคำนวณ Risk:Reward)</p>
</div>

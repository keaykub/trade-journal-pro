{{-- resources/views/components/trade-form/fields/exit-price.blade.php --}}
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

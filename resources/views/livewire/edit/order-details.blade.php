{{-- resources/views/trades/partials/fields/order-details.blade.php --}}
{{-- Position Size --}}
<div class="group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-weight-hanging text-blue-600 dark:text-blue-400 text-sm"></i>
        </div>
        Position Size
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Volume</div>
    </label>
    <div class="relative">
        <input type="number" step="0.01" wire:model.live="lotSize"
            placeholder="0.10"
            class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 font-mono text-lg shadow-sm hover:shadow-md pl-12"/>
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
            <i class="fas fa-layer-group text-sm"></i>
        </div>
    </div>
    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ขนาดของโพซิชัน (Lot Size) เช่น 0.01, 0.10, 1.00</p>
</div>

{{-- Order Type --}}
<div class="group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-layer-group text-purple-600 dark:text-purple-400 text-sm"></i>
        </div>
        Order Type
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Fixed</div>
    </label>
    <div class="relative">
        <div class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl text-slate-800 dark:text-white shadow-sm font-medium pl-12">
            Market Order
        </div>
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none">
            <i class="fas fa-bolt text-sm"></i>
        </div>
    </div>
    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ใช้ Market Order สำหรับการเทรดทั้งหมด</p>
</div>

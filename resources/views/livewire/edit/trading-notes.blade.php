{{-- resources/views/trades/partials/fields/trading-notes.blade.php --}}
<div class="mt-8 group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-sticky-note text-amber-600 dark:text-amber-400 text-sm"></i>
        </div>
        Trading Notes & Lessons
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Learning</div>
    </label>
    <textarea wire:model.defer="notes" rows="4"
        placeholder="บันทึกบทเรียนที่ได้รับ, จุดที่ควรปรับปรุง, หรือข้อสังเกตจากการเทรดนี้..."
        class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 resize-none shadow-sm hover:shadow-md"></textarea>
    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">เขียนบทเรียนและข้อสังเกตที่จะช่วยปรับปรุงการเทรดในอนาคต</p>
</div>

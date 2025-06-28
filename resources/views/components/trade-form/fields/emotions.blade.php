{{-- resources/views/components/trade-form/fields/emotions.blade.php --}}
{{-- Emotion Before Trading --}}
<div class="group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-smile text-yellow-600 dark:text-yellow-400 text-sm"></i>
        </div>
        Pre-Trade Emotion
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Mindset</div>
    </label>
    <div class="relative">
        <input type="text" wire:model.defer="emotionBefore" list="emotionBeforeOptions"
            placeholder="พิมพ์หรือเลือกอารมณ์ก่อนเทรด..."
            class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 shadow-sm hover:shadow-md pl-12"/>
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
            <i class="fas fa-heart text-sm"></i>
        </div>
    </div>
    <datalist id="emotionBeforeOptions">
        <option value="มั่นใจ">
        <option value="กังวล">
        <option value="ตื่นเต้น">
        <option value="สงบ">
        <option value="กลัว">
        <option value="โลภ">
        <option value="เป็นกลาง">
        <option value="เครียด">
        <option value="ประหม่า">
        <option value="คาดหวัง">
        <option value="ระมัดระวัง">
        <option value="กระตือรือร้น">
    </datalist>
    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">อารมณ์และจิตใจก่อนเปิดโพซิชัน</p>
</div>

{{-- Emotion After Trading --}}
<div class="group">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
        <div class="w-6 h-6 bg-gradient-to-r from-red-100 to-pink-100 dark:from-red-900/30 dark:to-pink-900/30 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
            <i class="fas fa-heart text-red-600 dark:text-red-400 text-sm"></i>
        </div>
        Post-Trade Emotion
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Reflection</div>
    </label>
    <div class="relative">
        <input type="text" wire:model.defer="emotionAfter" list="emotionAfterOptions"
            placeholder="พิมพ์หรือเลือกความรู้สึกหลังเทรด..."
            class="w-full px-4 py-4 bg-slate-50/80 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-2xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 text-slate-800 dark:text-white placeholder-slate-400 shadow-sm hover:shadow-md pl-12"/>
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
            <i class="fas fa-feather text-sm"></i>
        </div>
    </div>
    <datalist id="emotionAfterOptions">
        <option value="พอใจ">
        <option value="ผิดหวัง">
        <option value="เสียใจ">
        <option value="โล่งใจ">
        <option value="หงุดหงิด">
        <option value="ภูมิใจ">
        <option value="เป็นกลาง">
        <option value="เครียด">
        <option value="งงๆ">
        <option value="มั่นใจ">
        <option value="ช็อค">
        <option value="ตื่นเต้น">
    </datalist>
    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">ความรู้สึกหลังปิดโพซิชันหรือขณะนี้</p>
</div>

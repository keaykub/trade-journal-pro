{{-- resources/views/components/trade-form/reset-dropdown.blade.php --}}
<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <button @click="open = !open"
        class="flex items-center space-x-2 px-4 py-3 rounded-lg bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 hover:bg-orange-200 dark:hover:bg-orange-900/50 transition-all duration-200 font-medium border border-orange-200 dark:border-orange-800">
        <i class="fas fa-undo text-sm"></i>
        <span class="text-sm">รีเซ็ตข้อมูล</span>
        <i class="fas fa-chevron-down text-xs" :class="open ? 'rotate-180' : ''"></i>
    </button>

    {{-- Dropdown Menu --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 w-64 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg z-50">

        <div class="p-2">
            {{-- Reset Current Step --}}
            @if($step === 1)
            <button wire:click="resetStep1" @click="open = false"
                wire:confirm="ต้องการล้างข้อมูลพื้นฐานใช่หรือไม่?"
                class="w-full text-left px-4 py-3 rounded-lg hover:bg-orange-50 dark:hover:bg-orange-900/20 text-orange-700 dark:text-orange-300 transition-colors duration-200">
                <i class="fas fa-database mr-3"></i>
                รีเซ็ตข้อมูลพื้นฐาน
            </button>
            @elseif($step === 2)
            <button wire:click="resetStep2" @click="open = false"
                wire:confirm="ต้องการล้างข้อมูลการเทรดใช่หรือไม่?"
                class="w-full text-left px-4 py-3 rounded-lg hover:bg-orange-50 dark:hover:bg-orange-900/20 text-orange-700 dark:text-orange-300 transition-colors duration-200">
                <i class="fas fa-calculator mr-3"></i>
                รีเซ็ตข้อมูลการเทรด
            </button>
            @elseif($step === 3)
            <button wire:click="resetStep3" @click="open = false"
                wire:confirm="ต้องการล้างข้อมูลกลยุทธ์และรูปภาพใช่หรือไม่?"
                class="w-full text-left px-4 py-3 rounded-lg hover:bg-orange-50 dark:hover:bg-orange-900/20 text-orange-700 dark:text-orange-300 transition-colors duration-200">
                <i class="fas fa-brain mr-3"></i>
                รีเซ็ตกลยุทธ์ & รูปภาพ
            </button>
            @endif

            {{-- Divider --}}
            <div class="border-t border-slate-200 dark:border-slate-700 my-2"></div>

            {{-- Reset All --}}
            <button wire:click="resetAllForm" @click="open = false"
                wire:confirm="ต้องการล้างข้อมูลทั้งหมดและเริ่มใหม่ใช่หรือไม่?"
                class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-red-700 dark:text-red-300 transition-colors duration-200">
                <i class="fas fa-trash-alt mr-3"></i>
                ล้างข้อมูลทั้งหมด
            </button>
        </div>
    </div>
</div>

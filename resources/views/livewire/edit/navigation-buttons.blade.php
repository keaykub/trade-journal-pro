{{-- resources/views/trades/partials/navigation-buttons.blade.php --}}
<div class="flex justify-between items-center mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
    {{-- Back Button --}}
    @if($step > 1)
    <button type="button"
        wire:click="prevStep"
        class="flex items-center space-x-2 px-6 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
        <i class="fas fa-arrow-left"></i>
        <span>ย้อนกลับ</span>
    </button>
    @else
    <div></div>
    @endif

    {{-- Next/Submit Button --}}
    <div class="flex space-x-4">
        @if($step < $totalSteps)
        <button type="button"
            wire:click="nextStep"
            class="flex items-center space-x-2 px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 font-medium shadow-lg">
            <span>ขั้นตอนต่อไป</span>
            <i class="fas fa-arrow-right"></i>
        </button>
        @else
        <button type="submit"
            class="flex items-center space-x-2 px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 font-medium shadow-lg">
            <i class="fas fa-save"></i>
            <span>บันทึกการเทรด</span>
        </button>
        @endif
    </div>
</div>


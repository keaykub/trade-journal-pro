{{-- resources/views/trades/partials/fields/chart-screenshots.blade.php --}}
<div class="mt-8">
    <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">
        <div class="w-6 h-6 bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-camera text-purple-600 dark:text-purple-400 text-sm"></i>
        </div>
        Chart Screenshots
        <div class="ml-auto text-xs text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">Optional</div>
    </label>

    {{-- EXISTING IMAGES SECTION --}}
    @if(!empty($existingImages))
        @include('livewire.edit.existing-images')
    @endif

    {{-- NEW IMAGES SECTION --}}
    @include('livewire.edit.new-images')

    {{-- SUMMARY SECTION --}}
    @include('livewire.edit.summary')
</div>

{{-- resources/views/trades/partials/image-sections/new-images.blade.php --}}
<div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-blue-200 dark:border-blue-800">
    <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-300 mb-4 flex items-center">
        <i class="fas fa-plus mr-3"></i>
        เพิ่มรูปภาพใหม่
        @if(!empty($uploadedImages) && count($uploadedImages) > 0)
            <span class="ml-2 bg-blue-600 text-white px-3 py-1 rounded-full text-sm">{{ count($uploadedImages) }} รูป</span>
        @endif
    </h4>

    {{-- File Upload Area --}}
    @include('livewire.edit.upload-area')

    {{-- Preview New Images --}}
    @include('livewire.edit.new-images-preview')
</div>

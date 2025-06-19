{{-- resources/views/trades/partials/preview-modal.blade.php --}}
<div id="previewModal" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    {{-- Close Button --}}
    <button onclick="closePreviewModal()"
            class="absolute top-4 right-4 z-20 w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
        <i class="fas fa-times text-xl"></i>
    </button>

    {{-- Zoom Controls --}}
    <div class="absolute top-4 left-4 z-20 flex flex-col space-y-2">
        <button onclick="zoomIn()"
                class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
            <i class="fas fa-plus"></i>
        </button>
        <button onclick="zoomOut()"
                class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
            <i class="fas fa-minus"></i>
        </button>
        <button onclick="resetZoom()"
                class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
            <i class="fas fa-expand-arrows-alt text-sm"></i>
        </button>
    </div>

    {{-- Size Info --}}
    <div id="sizeInfo" class="absolute top-4 left-1/2 transform -translate-x-1/2 z-20 bg-black/60 text-white px-3 py-1 rounded-lg text-sm backdrop-blur-sm">
        <span id="currentSize"></span>
    </div>

    {{-- Image Container --}}
    <div class="relative w-full h-full flex items-center justify-center overflow-hidden" onclick="closePreviewModal()">
        <div id="imageWrapper" class="transition-transform duration-300 ease-out">
            <img id="previewImage"
                src=""
                alt="Preview"
                class="max-w-none max-h-none rounded-lg shadow-2xl cursor-move"
                onclick="event.stopPropagation()"
                onload="handleImageLoad(this)"
                style="transform-origin: center center;">
        </div>
    </div>

    {{-- Image Info Bar --}}
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-20 bg-black/70 text-white px-6 py-3 rounded-lg backdrop-blur-sm max-w-md">
        <p id="previewTitle" class="text-sm font-medium text-center mb-1"></p>
        <div class="flex justify-center space-x-4 text-xs text-gray-300">
            <span id="imageDimensions"></span>
            <span id="imageSize"></span>
        </div>
    </div>
</div>

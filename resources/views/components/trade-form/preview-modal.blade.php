{{-- resources/views/components/trade-form/preview-modal.blade.php --}}
<div id="previewModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4">
    {{-- Close Button --}}
    <button onclick="closePreviewModal()"
            class="absolute top-4 right-4 z-20 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
        <i class="fas fa-times text-xl"></i>
    </button>

    {{-- Zoom Controls --}}
    <div class="absolute top-4 left-4 z-20 flex flex-col space-y-2">
        <button onclick="zoomIn()"
                class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
            <i class="fas fa-plus"></i>
        </button>
        <button onclick="zoomOut()"
                class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
            <i class="fas fa-minus"></i>
        </button>
        <button onclick="resetZoom()"
                class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm">
            <i class="fas fa-home"></i>
        </button>
    </div>

    {{-- Image Info --}}
    <div class="absolute bottom-4 left-4 z-20 bg-black bg-opacity-70 text-white px-4 py-2 rounded-lg backdrop-blur-sm">
        <div class="text-xs space-y-1">
            <div>Size: <span id="currentSize">100%</span></div>
            <div>Dimensions: <span id="imageDimensions">-</span></div>
            <div>File Size: <span id="imageSize">-</span></div>
        </div>
    </div>

    {{-- Image Container --}}
    <div class="relative max-w-full max-h-full flex items-center justify-center" onclick="closePreviewModal()">
        <div id="imageWrapper" class="transition-transform duration-200 ease-out">
            <img id="previewImage"
                src=""
                alt="Preview"
                class="max-w-full max-h-full object-contain rounded-lg shadow-2xl cursor-grab active:cursor-grabbing transition-all duration-200"
                onclick="event.stopPropagation()"
                onload="handleImageLoad(this)">
        </div>

        {{-- Image Title --}}
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-70 text-white px-4 py-2 rounded-lg backdrop-blur-sm">
            <p id="previewTitle" class="text-sm font-medium"></p>
        </div>
    </div>

    {{-- Instructions --}}
    <div class="absolute bottom-4 right-4 z-20 bg-black bg-opacity-70 text-white px-4 py-2 rounded-lg backdrop-blur-sm text-xs">
        <div class="space-y-1">
            <div><span class="bg-white bg-opacity-20 px-2 py-1 rounded font-mono text-xs">Esc</span> Close</div>
            <div><span class="bg-white bg-opacity-20 px-2 py-1 rounded font-mono text-xs">+</span> Zoom In</div>
            <div><span class="bg-white bg-opacity-20 px-2 py-1 rounded font-mono text-xs">-</span> Zoom Out</div>
            <div><span class="bg-white bg-opacity-20 px-2 py-1 rounded font-mono text-xs">0</span> Reset</div>
        </div>
    </div>
</div>

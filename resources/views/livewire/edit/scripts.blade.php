<script>
let currentZoom = 1;
let maxZoom = 3;
let minZoom = 0.1;
let isDragging = false;
let startX, startY, translateX = 0, translateY = 0;

function openPreviewModal(imageUrl, title) {
    const modal = document.getElementById('previewModal');
    const previewImage = document.getElementById('previewImage');
    const previewTitle = document.getElementById('previewTitle');

    // Reset states
    currentZoom = 1;
    translateX = 0;
    translateY = 0;

    previewImage.src = imageUrl;
    previewTitle.textContent = title;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // ป้องกันการ scroll ของ body
    document.body.style.overflow = 'hidden';

    // Get image info (will be set in handleImageLoad)
    fetchImageInfo(imageUrl);

    // เพิ่ม event listeners หลังจากที่ modal เปิดแล้ว
    setupImageEventListeners();
}

function closePreviewModal() {
    const modal = document.getElementById('previewModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');

    // คืนค่าการ scroll ของ body
    document.body.style.overflow = 'auto';

    // Reset transform
    const imageWrapper = document.getElementById('imageWrapper');
    if (imageWrapper) {
        imageWrapper.style.transform = '';
    }

    // ลบ event listeners เพื่อป้องกัน memory leak
    removeImageEventListeners();
}

function setupImageEventListeners() {
    const previewImage = document.getElementById('previewImage');
    const modal = document.getElementById('previewModal');

    if (previewImage) {
        // Mouse wheel zoom บนรูปภาพ - ซูมที่กลาง
        previewImage.addEventListener('wheel', handleCenterZoom, { passive: false });

        // Drag functionality
        previewImage.addEventListener('mousedown', startDrag);
    }

    if (modal) {
        // Mouse wheel zoom บน modal - ซูมที่กลาง
        modal.addEventListener('wheel', handleCenterZoom, { passive: false });
    }

    // Global mouse events สำหรับ drag
    document.addEventListener('mousemove', drag);
    document.addEventListener('mouseup', endDrag);
}

function removeImageEventListeners() {
    const previewImage = document.getElementById('previewImage');
    const modal = document.getElementById('previewModal');

    if (previewImage) {
        previewImage.removeEventListener('wheel', handleCenterZoom);
        previewImage.removeEventListener('mousedown', startDrag);
    }

    if (modal) {
        modal.removeEventListener('wheel', handleCenterZoom);
    }

    document.removeEventListener('mousemove', drag);
    document.removeEventListener('mouseup', endDrag);
}

// ฟังก์ชัน zoom ที่กลางรูป - ง่ายมาก!
function handleCenterZoom(e) {
    e.preventDefault();
    e.stopPropagation();

    if (e.deltaY < 0) {
        // เลื่อนขึ้น = ขยาย (ที่กลาง)
        zoomIn();
    } else {
        // เลื่อนลง = ย่อ (ที่กลาง)
        zoomOut();
    }
}

function handleImageLoad(img) {
    const screenWidth = window.innerWidth - 100; // padding
    const screenHeight = window.innerHeight - 150; // padding + info bars

    const imgWidth = img.naturalWidth;
    const imgHeight = img.naturalHeight;

    // คำนวณขนาดที่เหมาะสม
    const scaleX = screenWidth / imgWidth;
    const scaleY = screenHeight / imgHeight;
    const optimalScale = Math.min(scaleX, scaleY, 1); // ไม่ขยายเกินขนาดจริง

    // Set optimal size
    currentZoom = optimalScale;
    updateImageTransform();

    // Update info
    updateSizeInfo();
    updateImageDimensions(imgWidth, imgHeight);
}

function updateImageTransform() {
    const imageWrapper = document.getElementById('imageWrapper');
    if (imageWrapper) {
        imageWrapper.style.transform = `scale(${currentZoom}) translate(${translateX}px, ${translateY}px)`;
    }
}

// Zoom ที่กลาง - ไม่ต้องคำนวณซับซ้อน
function zoomIn() {
    if (currentZoom < maxZoom) {
        currentZoom = Math.min(currentZoom * 1.2, maxZoom);
        updateImageTransform();
        updateSizeInfo();
    }
}

function zoomOut() {
    if (currentZoom > minZoom) {
        currentZoom = Math.max(currentZoom / 1.2, minZoom);
        updateImageTransform();
        updateSizeInfo();
    }
}

function resetZoom() {
    const img = document.getElementById('previewImage');
    if (img && img.naturalWidth) {
        handleImageLoad(img);
    }
    translateX = 0;
    translateY = 0;
    updateImageTransform();
}

function updateSizeInfo() {
    const currentSizeEl = document.getElementById('currentSize');
    if (currentSizeEl) {
        const percentage = Math.round(currentZoom * 100);
        currentSizeEl.textContent = `${percentage}%`;
    }
}

function updateImageDimensions(width, height) {
    const dimensionsEl = document.getElementById('imageDimensions');
    if (dimensionsEl) {
        dimensionsEl.textContent = `${width} × ${height}px`;
    }
}

function fetchImageInfo(imageUrl) {
    // สำหรับแสดงขนาดไฟล์ (optional)
    fetch(imageUrl, { method: 'HEAD' })
        .then(response => {
            const size = response.headers.get('content-length');
            if (size) {
                const sizeEl = document.getElementById('imageSize');
                if (sizeEl) {
                    const sizeKB = Math.round(size / 1024);
                    sizeEl.textContent = `${sizeKB} KB`;
                }
            }
        })
        .catch(() => {
            // ไม่แสดงข้อผิดพลาด
        });
}

function startDrag(e) {
    if (currentZoom > 1) {
        isDragging = true;
        startX = e.clientX - translateX;
        startY = e.clientY - translateY;
        document.getElementById('previewImage').style.cursor = 'grabbing';
        e.preventDefault(); // ป้องกันการ select image
    }
}

function drag(e) {
    if (isDragging && currentZoom > 1) {
        e.preventDefault();
        translateX = e.clientX - startX;
        translateY = e.clientY - startY;
        updateImageTransform();
    }
}

function endDrag() {
    isDragging = false;
    const img = document.getElementById('previewImage');
    if (img) {
        img.style.cursor = currentZoom > 1 ? 'grab' : 'default';
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(event) {
    const modal = document.getElementById('previewModal');
    if (modal && !modal.classList.contains('hidden')) {
        switch(event.key) {
            case 'Escape':
                closePreviewModal();
                break;
            case '+':
            case '=':
                event.preventDefault();
                zoomIn();
                break;
            case '-':
                event.preventDefault();
                zoomOut();
                break;
            case '0':
                event.preventDefault();
                resetZoom();
                break;
        }
    }
});

// Click outside to close
document.addEventListener('click', function(event) {
    const modal = document.getElementById('previewModal');
    if (modal && !modal.classList.contains('hidden') && event.target === modal) {
        closePreviewModal();
    }
});

let dragCounter = 0;

function handleDragEnter(event) {
    event.preventDefault();
    event.stopPropagation();

    dragCounter++; // เพิ่ม counter

    if (dragCounter === 1) { // แสดง overlay เฉพาะครั้งแรก
        // ปิด pointer events ของ elements ข้างใน
        const uploadZone = document.querySelector('.upload-zone');
        if (uploadZone) {
            uploadZone.querySelectorAll('*').forEach(el => {
                el.style.pointerEvents = 'none';
            });
        }

        const overlay = document.querySelector('.drag-overlay');
        if (overlay) {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }
    }
}

function handleDragLeave(event) {
    event.preventDefault();
    event.stopPropagation();

    dragCounter--; // ลด counter

    if (dragCounter <= 0) { // ซ่อน overlay เมื่อออกจริงๆ
        dragCounter = 0; // reset counter

        // เปิด pointer events กลับ
        const uploadZone = document.querySelector('.upload-zone');
        if (uploadZone) {
            uploadZone.querySelectorAll('*').forEach(el => {
                el.style.pointerEvents = '';
            });
        }

        const overlay = document.querySelector('.drag-overlay');
        if (overlay) {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }
    }
}

function handleDragOver(event) {
    event.preventDefault();
    event.stopPropagation();
    // ไม่ต้องแสดง overlay ที่นี่
}

function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();

    dragCounter = 0; // reset counter

    // เปิด pointer events กลับ
    const uploadZone = document.querySelector('.upload-zone');
    if (uploadZone) {
        uploadZone.querySelectorAll('*').forEach(el => {
            el.style.pointerEvents = '';
        });
    }

    const input = document.getElementById('imageUpload');
    if (input) {
        input.files = event.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
    }

    const overlay = document.querySelector('.drag-overlay');
    if (overlay) {
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
    }
}
</script>

{{-- resources/views/components/trade-form/scripts.blade.php --}}
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

        // เพิ่ม mouse wheel event listener เมื่อเปิด modal
        setupWheelZoom();
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

        // ลบ wheel event listener เมื่อปิด modal
        removeWheelZoom();
    }

    // ฟังก์ชันสำหรับเพิ่ม wheel zoom
    function setupWheelZoom() {
        const modal = document.getElementById('previewModal');
        const image = document.getElementById('previewImage');

        if (modal) {
            modal.addEventListener('wheel', handleWheelZoom, { passive: false });
        }
        if (image) {
            image.addEventListener('wheel', handleWheelZoom, { passive: false });
        }
    }

    // ฟังก์ชันสำหรับลบ wheel zoom
    function removeWheelZoom() {
        const modal = document.getElementById('previewModal');
        const image = document.getElementById('previewImage');

        if (modal) {
            modal.removeEventListener('wheel', handleWheelZoom);
        }
        if (image) {
            image.removeEventListener('wheel', handleWheelZoom);
        }
    }

    // ตัวจัดการ wheel event
    function handleWheelZoom(e) {
        if (!document.getElementById('previewModal').classList.contains('hidden')) {
            e.preventDefault();
            e.stopPropagation();

            if (e.deltaY < 0) {
                // เลื่อนขึ้น = ขยาย
                zoomIn();
            } else {
                // เลื่อนลง = ย่อ
                zoomOut();
            }
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

    // Mouse/Touch drag functionality
    document.getElementById('previewImage')?.addEventListener('mousedown', startDrag);
    document.addEventListener('mousemove', drag);
    document.addEventListener('mouseup', endDrag);

    function startDrag(e) {
        if (currentZoom > 1) {
            isDragging = true;
            startX = e.clientX - translateX;
            startY = e.clientY - translateY;
            document.getElementById('previewImage').style.cursor = 'grabbing';
            e.preventDefault();
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

    // Drag and Drop functionality
    let dragCounter = 0;

    function handleDragEnter(event) {
        event.preventDefault();
        event.stopPropagation();
        dragCounter++;

        if (dragCounter === 1) {
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
        dragCounter--;

        if (dragCounter <= 0) {
            dragCounter = 0;

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
    }

    function handleDrop(event) {
        event.preventDefault();
        event.stopPropagation();
        dragCounter = 0;

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

    // Click outside to close
    document.getElementById('previewModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closePreviewModal();
        }
    });
</script>

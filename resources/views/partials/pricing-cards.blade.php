<section class="py-16 px-6 -mt-8"
         x-data="pricingData()"
         @payment-success.window="handlePaymentSuccess($event.detail)">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Free Plan -->
            <div class="card-hover bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">เริ่มต้น</h3>
                    <p class="text-gray-600 mb-6">สำหรับเทรดเดอร์มือใหม่</p>
                    <div class="text-4xl font-bold text-gray-800 mb-2">ฟรี</div>
                    <p class="text-gray-500">ตลอดชีพ</p>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">บันทึกเทรดได้ 50 รายการ</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">สถิติพื้นฐาน</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">กราฟง่าย ๆ</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">Export CSV</span>
                    </div>
                    <div class="flex items-center opacity-50">
                        <div class="w-5 h-5 bg-gray-300 rounded-full mr-3"></div>
                        <span class="text-gray-400 line-through">AI โค้ช</span>
                    </div>
                    <div class="flex items-center opacity-50">
                        <div class="w-5 h-5 bg-gray-300 rounded-full mr-3"></div>
                        <span class="text-gray-400 line-through">แจ้งเตือน Email</span>
                    </div>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="block w-full bg-gray-100 text-gray-800 font-semibold py-3 rounded-full hover:bg-gray-200 transition-colors text-center">
                        ใช้งานแผนฟรี
                    </a>
                @else
                    <a href="{{ route('register') }}" class="block w-full bg-gray-100 text-gray-800 font-semibold py-3 rounded-full hover:bg-gray-200 transition-colors text-center">
                        เริ่มใช้ฟรี
                    </a>
                @endauth
            </div>

            <!-- Pro Plan (Popular) -->
            <div class="card-hover bg-white rounded-2xl p-8 shadow-xl border-2 border-blue-500 relative">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="popular-badge text-white px-6 py-2 rounded-full text-sm font-bold">
                        ⭐ ยอดนิยม
                    </span>
                </div>

                <div class="text-center mb-8 pt-4">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">โปร</h3>
                    <p class="text-gray-600 mb-6">สำหรับเทรดเดอร์จริงจัง</p>
                    <div class="text-4xl font-bold text-blue-600 mb-2">
                        <span x-show="!yearly">฿249</span>
                        <span x-show="yearly">฿2,390</span>
                    </div>
                    <p class="text-gray-500">
                        <span x-show="!yearly">ต่อเดือน</span>
                        <span x-show="yearly">ต่อปี (ประหยัด ฿1,198)</span>
                    </p>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">บันทึกเทรดไม่จำกัด</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">สถิติและกราฟครบครัน</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">AI โค้ช (50 คำถาม/วัน)</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">Export CSV/PDF</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">แจ้งเตือน Email รายวัน</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">อัปโหลดรูป 5 รูป/เทรด</span>
                    </div>
                </div>

                @auth
                    @if(auth()->user()->hasActiveSubscription())
                        <a href="{{ route('dashboard') }}"
                        class="block w-full bg-green-600 text-white font-bold py-3 rounded-full hover:bg-green-700 transition-colors shadow-lg text-center">
                            ไปยังหน้าแดชบอร์ด
                        </a>
                    @else
                        <button @click="selectPlan('pro')"
                                class="block w-full bg-blue-600 text-white font-bold py-3 rounded-full hover:bg-blue-700 transition-colors shadow-lg text-center">
                            เลือกแผนโปร
                        </button>
                    @endif
                @else
                    <a href="{{ route('register') }}"
                    class="block w-full bg-blue-600 text-white font-bold py-3 rounded-full hover:bg-blue-700 transition-colors shadow-lg text-center">
                        เริ่มทดลอง 14 วันฟรี
                    </a>
                @endauth
            </div>

            <!-- Premium Plan -->
            <div class="card-hover bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">พรีเมียม</h3>
                    <p class="text-gray-600 mb-6">สำหรับเทรดเดอร์มืออาชีพ</p>
                    <div class="text-4xl font-bold text-purple-600 mb-2">
                        <span x-show="!yearly">฿359</span>
                        <span x-show="yearly">฿4,790</span>
                    </div>
                    <p class="text-gray-500">
                        <span x-show="!yearly">ต่อเดือน</span>
                        <span x-show="yearly">ต่อปี (ประหยัด ฿2,398)</span>
                    </p>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">ทุกอย่างในแผนโปร</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">AI โค้ช ไม่จำกัด</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">วิเคราะห์ขั้นสูง</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">แชร์บันทึกเทรดได้</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">API Access</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 feature-check rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700">Priority Support</span>
                    </div>
                </div>

                @auth
                    @if(auth()->user()->hasActiveSubscription())
                        <a href="{{ route('dashboard') }}"
                        class="block w-full bg-green-600 text-white font-bold py-3 rounded-full hover:bg-green-700 transition-colors text-center">
                            ไปยังหน้าแดชบอร์ด
                        </a>
                    @else
                        <button @click="selectPlan('premium')"
                                class="block w-full bg-purple-600 text-white font-bold py-3 rounded-full hover:bg-purple-700 transition-colors text-center">
                            เลือกแผนพรีเมียม
                        </button>
                    @endif
                @else
                    <a href="{{ route('register') }}"
                    class="block w-full bg-purple-600 text-white font-bold py-3 rounded-full hover:bg-purple-700 transition-colors text-center">
                        เริ่มทดลอง 14 วันฟรี
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Include Payment Modal -->
    @include('partials.payment-modal')
</section>

<script>
function pricingData() {
    return {
        yearly: false,
        showPaymentModal: false,
        selectedPlan: {},
        paymentMethod: 'qr',
        selectedFile: null,
        previewUrl: null,
        isSubmitting: false,

        plans: {
            'pro': {
                monthly: {
                    id: 'pro-monthly',
                    name: 'โปร (รายเดือน)',
                    description: 'สำหรับเทรดเดอร์จริงจัง',
                    price: 249,
                    billing: 'ต่อเดือน'
                },
                yearly: {
                    id: 'pro-yearly',
                    name: 'โปร (รายปี)',
                    description: 'สำหรับเทรดเดอร์จริงจัง - ประหยัด 20%',
                    price: 2390,
                    billing: 'ต่อปี (ประหยัด ฿1,198)'
                }
            },
            'premium': {
                monthly: {
                    id: 'premium-monthly',
                    name: 'พรีเมียม (รายเดือน)',
                    description: 'สำหรับเทรดเดอร์มืออาชีพ',
                    price: 359,
                    billing: 'ต่อเดือน'
                },
                yearly: {
                    id: 'premium-yearly',
                    name: 'พรีเมียม (รายปี)',
                    description: 'สำหรับเทรดเดอร์มืออาชีพ - ประหยัด 20%',
                    price: 4790,
                    billing: 'ต่อปี (ประหยัด ฿2,398)'
                }
            }
        },

        init() {
            // Set default transfer date to today
            this.transferDate = new Date().toISOString().split('T')[0];
        },

        selectPlan(planType) {
            const billing = this.yearly ? 'yearly' : 'monthly';
            this.selectedPlan = this.plans[planType][billing];
            this.showPaymentModal = true;
            document.body.style.overflow = 'hidden';
        },

        closePaymentModal() {
            this.showPaymentModal = false;
            this.resetForm();
            document.body.style.overflow = 'auto';
        },

        resetForm() {
            this.selectedFile = null;
            this.previewUrl = null;
            this.paymentMethod = 'qr';
            this.isSubmitting = false;
        },

        handleFileUpload(event) {
            const files = event.type === 'drop' ? event.dataTransfer.files : event.target.files;
            const file = files[0];

            if (!file) return;

            // Validate file type
            if (!file.type.startsWith('image/')) {
                this.showAlert('กรุณาเลือกไฟล์รูปภาพเท่านั้น (JPG, PNG, JPEG)', 'error');
                return;
            }

            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                this.showAlert('ขนาดไฟล์ต้องไม่เกิน 5MB', 'error');
                return;
            }

            this.selectedFile = file;

            // Create preview
            const reader = new FileReader();
            reader.onload = (e) => {
                this.previewUrl = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        removeFile() {
            this.selectedFile = null;
            this.previewUrl = null;
            const fileInput = document.getElementById('payment-slip');
            if (fileInput) fileInput.value = '';
        },

        validateForm() {
            if (!this.selectedFile) {
                this.showAlert('กรุณาแนบสลิปการชำระเงิน', 'error');
                return false;
            }

            return true;
        },

        async submitPayment() {
            if (!this.validateForm()) return;

            this.isSubmitting = true;

            try {
                const formData = new FormData();
                formData.append('plan_id', this.selectedPlan.id);
                formData.append('payment_method', this.paymentMethod);
                formData.append('slip_image', this.selectedFile);

                console.log('Submitting payment with data:', {
                    plan_id: this.selectedPlan.id,
                    payment_method: this.paymentMethod,
                });

                const response = await fetch('{{ route("pricing.check-slip") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();

                if (result.success) {
                    this.showAlert('ชำระเงินสำเร็จ', 'success');
                    this.closePaymentModal();

                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 1500);
                } else {
                    this.showAlert(result.message || 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'error');
                }
            } catch (error) {
                console.error('Payment submission error:', error);
                this.showAlert('เกิดข้อผิดพลาดในการส่งข้อมูล กรุณาลองใหม่อีกครั้ง', 'error');
            } finally {
                this.isSubmitting = false;
            }
        },

        showAlert(message, type = 'info') {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };

            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-circle',
                warning: 'fas fa-exclamation-triangle',
                info: 'fas fa-info-circle'
            };

            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert-notification');
            existingAlerts.forEach(alert => alert.remove());

            // Create new alert
            const alert = document.createElement('div');
            alert.className = `alert-notification fixed top-4 right-4 ${colors[type]} text-white p-4 rounded-lg shadow-lg z-50 max-w-md`;
            alert.innerHTML = `
                <div class="flex items-start">
                    <i class="${icons[type]} mt-1 mr-3"></i>
                    <div>
                        <p>${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            document.body.appendChild(alert);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alert.parentElement) {
                    alert.remove();
                }
            }, 5000);
        },

        formatPrice(price) {
            return new Intl.NumberFormat('th-TH').format(price);
        },

        // Handle keyboard events
        handleKeydown(event) {
            if (event.key === 'Escape' && this.showPaymentModal) {
                this.closePaymentModal();
            }
        }
    }
}

// Add global event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Handle keyboard events
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            // Close modal if open
            const modal = document.querySelector('[x-data*="pricingData"]');
            if (modal && modal.__x) {
                modal.__x.$data.closePaymentModal();
            }
        }
    });

    // Prevent body scroll when modal is open
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const body = document.body;
                if (body.style.overflow === 'hidden') {
                    body.classList.add('modal-open');
                } else {
                    body.classList.remove('modal-open');
                }
            }
        });
    });

    observer.observe(document.body, { attributes: true });
});
</script>

<style>
/* Modal and animation styles */
.modal-open {
    overflow: hidden !important;
}

.feature-check {
    background: linear-gradient(135deg, #10b981, #059669);
}

.popular-badge {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

/* File upload area styling */
.file-upload-area {
    transition: all 0.3s ease;
}

.file-upload-area:hover {
    border-color: #3b82f6;
    background-color: #f8fafc;
}

/* Alert animation */
.alert-notification {
    animation: slideInRight 0.3s ease-out;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Loading spinner */
.fa-spin {
    animation: fa-spin 1s infinite linear;
}

@keyframes fa-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Form validation styles */
.form-error {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
}

.form-success {
    border-color: #10b981 !important;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
}
</style>

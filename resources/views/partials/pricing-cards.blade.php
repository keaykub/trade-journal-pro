<section class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8"
             x-data="pricingData()"
             @payment-success.window="handlePaymentSuccess($event.detail)">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">

                <!-- Free Plan -->
                <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-lg shadow-blue-100/50 border border-blue-100 hover:shadow-blue-200/60 hover:-translate-y-2 transition-all duration-300">
                    <div class="text-center mb-6 sm:mb-8">
                        <h3 class="text-2xl font-bold text-blue-900 mb-2">เริ่มต้น</h3>
                        <p class="text-blue-600 mb-4 sm:mb-6">สำหรับเทรดเดอร์มือใหม่</p>
                        <div class="text-4xl font-bold text-blue-800 mb-2">ฟรี</div>
                        <p class="text-blue-500">ตลอดชีพ</p>
                    </div>

                    <div class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">บันทึกเทรดได้ 50 รายการ</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">สถิติพื้นฐาน</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">ฟังก์ชันพื้นฐาน</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">แชร์บันทึกเทรดได้</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">อัปโหลดรูป 3 รูป/เทรด</span>
                        </div>
                        <div class="flex items-center opacity-50">
                            <div class="w-5 h-5 bg-blue-200 rounded-full mr-3 flex-shrink-0"></div>
                            <span class="text-blue-400 line-through text-sm sm:text-base">AI แชท</span>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="block w-full bg-blue-100 text-blue-800 font-semibold py-3 sm:py-4 rounded-full hover:bg-blue-200 transition-all duration-300 text-center text-sm sm:text-base">
                            ใช้งานแผนฟรี
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="block w-full bg-blue-100 text-blue-800 font-semibold py-3 sm:py-4 rounded-full hover:bg-blue-200 transition-all duration-300 text-center text-sm sm:text-base">
                            เริ่มใช้ฟรี
                        </a>
                    @endauth
                </div>

                <!-- Pro Plan (Popular) -->
                <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-2xl shadow-blue-500/20 border-2 border-blue-500 relative hover:shadow-blue-500/30 hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 sm:px-6 py-2 rounded-full text-xs sm:text-sm font-bold shadow-lg">
                            <i class="fas fa-star text-yellow-300 mr-1"></i>
                            ยอดนิยม
                        </span>
                    </div>

                    <div class="text-center mb-6 sm:mb-8 pt-4">
                        <h3 class="text-2xl font-bold text-blue-900 mb-2">โปร</h3>
                        <p class="text-blue-600 mb-4 sm:mb-6">สำหรับเทรดเดอร์จริงจัง</p>
                        <div class="text-4xl font-bold text-blue-600 mb-2">
                            <span x-show="!yearly">฿249</span>
                            <span x-show="yearly">฿2,390</span>
                        </div>
                        <p class="text-blue-500">
                            <span x-show="!yearly">ต่อเดือน</span>
                            <span x-show="yearly">ต่อปี (ประหยัด ฿1,198)</span>
                        </p>
                    </div>

                    <div class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">บันทึกเทรดไม่จำกัด</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">สถิติและกราฟขั้นสูง</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">วิเคราะห์สถิติขั้นสูง</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">อัปโหลดรูป 10 รูป/เทรด</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">ฟังก์ชันพื้นฐานทั้งหมด</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-400 to-blue-500 rounded-full mr-3 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-rocket text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">AI แชท
                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-full ml-2">
                                    มาในเร็วๆนี้
                                </span>
                            </span>
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->subscribed('default') && auth()->user()->subscription('default')->valid())
                            <a href="{{ route('dashboard') }}"
                            class="block w-full bg-blue-600 text-white font-bold py-3 sm:py-4 rounded-full hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl text-center text-sm sm:text-base">
                                ไปยังหน้าแดชบอร์ด
                            </a>
                        @else
                            <section x-data="pricingData()">
                                <button @click="selectPlan('pro')"
                                        class="block w-full bg-blue-600 text-white font-bold py-3 sm:py-4 rounded-full hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl text-center text-sm sm:text-base">
                                    เลือกแผนโปร
                                </button>
                            </section>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                        class="block w-full bg-blue-600 text-white font-bold py-3 sm:py-4 rounded-full hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl text-center text-sm sm:text-base">
                            ชำระเงิน
                        </a>
                    @endauth
                </div>

                <!-- Premium Plan -->
                <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-lg shadow-blue-100/50 border border-blue-100 hover:shadow-blue-200/60 hover:-translate-y-2 transition-all duration-300 md:col-span-2 lg:col-span-1">
                    <div class="text-center mb-6 sm:mb-8">
                        <h3 class="text-2xl font-bold text-blue-900 mb-2">พรีเมียม</h3>
                        <p class="text-blue-600 mb-4 sm:mb-6">สำหรับเทรดเดอร์มืออาชีพ</p>
                        <div class="text-4xl font-bold text-blue-700 mb-2">
                            <span x-show="!yearly">฿359</span>
                            <span x-show="yearly">฿4,790</span>
                        </div>
                        <p class="text-blue-500">
                            <span x-show="!yearly">ต่อเดือน</span>
                            <span x-show="yearly">ต่อปี (ประหยัด ฿2,398)</span>
                        </p>
                    </div>

                    <div class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">ทุกอย่างในแผนโปร</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">AI แชท ไม่จำกัด</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">วิเคราะห์ขั้นสูง</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">ฟังก์ชันพื้นฐานทั้งหมด</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">API Access</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <span class="text-blue-700 text-sm sm:text-base">Priority Support</span>
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->hasActiveSubscription())
                            {{-- <a href="{{ route('dashboard') }}"
                            class="block w-full bg-blue-600 text-white font-bold py-3 sm:py-4 rounded-full hover:bg-blue-700 transition-all duration-300 text-center text-sm sm:text-base">
                                ไปยังหน้าแดชบอร์ด
                            </a> --}}
                            <button disabled
                                class="block w-full bg-blue-300 text-white font-bold py-3 sm:py-4 rounded-full cursor-not-allowed text-center relative text-sm sm:text-base">
                            <span class="opacity-60">เลือกแผนพรีเมียม</span>
                            <span class="absolute top-1 right-3 bg-blue-200 text-blue-800 text-xs px-2 py-1 rounded-full font-medium">
                                เร็วๆ นี้
                            </span>
                        </button>
                        @else
                            <button disabled
                                    class="block w-full bg-blue-300 text-white font-bold py-3 sm:py-4 rounded-full cursor-not-allowed transition-all duration-300 text-center relative text-sm sm:text-base">
                                <span class="opacity-60">เลือกแผนพรีเมียม</span>
                                <span class="absolute top-1 right-3 bg-blue-200 text-blue-800 text-xs px-2 py-1 rounded-full font-medium">
                                    เร็วๆ นี้
                                </span>
                            </button>
                        @endif
                    @else
                        <button disabled
                                class="block w-full bg-blue-300 text-white font-bold py-3 sm:py-4 rounded-full cursor-not-allowed text-center relative text-sm sm:text-base">
                            <span class="opacity-60">เลือกแผนพรีเมียม</span>
                            <span class="absolute top-1 right-3 bg-blue-200 text-blue-800 text-xs px-2 py-1 rounded-full font-medium">
                                เร็วๆ นี้
                            </span>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <script>
        function pricingData() {
            return {
                yearly: false, // ถ้าจะมี plan รายปีในอนาคต
                loading: false,
                selectPlan(plan) {
                    this.loading = true;

                    fetch('/checkout/redirect', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            plan: plan,
                            yearly: this.yearly
                        })
                    })
                    .then(async res => {
                        this.loading = false;
                        const data = await res.json();

                        if (data.url) {
                            window.location.href = data.url;
                        } else if (data.redirect) {
                            window.location.href = data.redirect;
                        } else if (data.error) {
                            alert(data.error);
                        } else {
                            alert('เกิดข้อผิดพลาด ไม่พบลิงก์ชำระเงิน');
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        this.loading = false;
                        alert('เชื่อมต่อไม่ได้ กรุณาลองใหม่');
                    });
                }
            }
        }
    </script>

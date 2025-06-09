<section class="py-20 px-6 relative">
    <div class="dot-pattern absolute inset-0 opacity-30"></div>
    <div class="max-w-6xl mx-auto relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gradient">
                ฟีเจอร์เด่นที่จะเปลี่ยนการเทรดของคุณ
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                เครื่องมือครบครันที่ออกแบบมาเพื่อเทรดเดอร์โดยเฉพาะ
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($features as $feature)
            <div class="card-hover p-8 bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-r {{ $feature['color'] }} rounded-2xl flex items-center justify-center mb-6">
                    <i class="{{ $feature['icon'] }} text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">{{ $feature['title'] }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $feature['description'] }}</p>

                <div class="mt-6 flex items-center {{ $feature['link_color'] }} font-semibold cursor-pointer hover:opacity-80">
                    <span>{{ $feature['link_text'] }}</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- resources/views/trades/partials/status-bar.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="px-4 py-4">
        <div class="relative flex items-center justify-between w-full">
            @for($i = 1; $i <= $totalSteps; $i++)
                <div class="flex-1 relative flex flex-col items-center text-center">
                    {{-- เส้นเชื่อม - เชื่อมจากจุดกลางของวงกลมแต่ละจุด --}}
                    @if($i > 1)
                        <div class="absolute top-5 h-0.5 z-0
                                    {{ $i <= $step ? 'bg-blue-500' : 'bg-gray-300 dark:bg-gray-700' }}"
                            style="right: 50%; left: -50%; transform: translateY(-50%);"></div>
                    @endif

                    {{-- วงกลม --}}
                    <div class="relative z-10 flex items-center justify-center w-10 h-10 rounded-full text-sm font-semibold border-2
                        {{ $i < $step ? 'bg-blue-500 text-white border-blue-500' :
                        ($i === $step ? 'bg-white text-blue-600 border-blue-500 dark:bg-gray-800' :
                        'bg-gray-100 text-gray-400 border-gray-300 dark:bg-gray-700 dark:border-gray-600') }}">
                        @if($i < $step)
                            <i class="fas fa-check text-xs"></i>
                        @else
                            {{ $i }}
                        @endif
                    </div>

                    {{-- Label --}}
                    <span class="mt-2 text-xs font-medium whitespace-nowrap
                        {{ $i === $step ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                        @if($i === 1) ข้อมูลพื้นฐาน
                        @elseif($i === 2) รายละเอียดเทรด
                        @elseif($i === 3) กลยุทธ์ & จิตวิทยา
                        @endif
                    </span>
                </div>
            @endfor
        </div>
    </div>
</div>

@extends('layouts.app')

@section('title', 'LF Catalog')



@section('content')
    <div id="default-carousel" class="relative w-full top-7" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative aspect-[16/7] md:aspect-[16/5] overflow-hidden">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('img/sl1new.png') }}"
                    class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('img/sl2.jpg') }}"
                    class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('img/sl3.jpg') }}"
                    class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('img/sl4.jpg') }}"
                    class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 5 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('img/sl2.jpg') }}"
                    class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-base" aria-current="true" aria-label="Slide 1"
                data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-base" aria-current="false" aria-label="Slide 2"
                data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-base" aria-current="false" aria-label="Slide 3"
                data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-base" aria-current="false" aria-label="Slide 4"
                data-carousel-slide-to="3"></button>
            <button type="button" class="w-3 h-3 rounded-base" aria-current="false" aria-label="Slide 5"
                data-carousel-slide-to="4"></button>
        </div>
        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-base bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-base bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-5 h-5 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m9 5 7 7-7 7" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    <section class="bg-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-semibold text-center text-gray-900 mb-12">
                Berbagai produk LF_Catalog.
            </h2>

            <div
                class="flex overflow-x-auto pb-8 hide-scrollbar snap-x items-end justify-start md:justify-center space-x-8 md:space-x-12">

                <div class="shrink-0 flex flex-col items-center text-center snap-center group cursor-pointer"
                    onclick="window.location='{{ route('category', 'iphone13') }}'">
                    <div class="h-24 flex items-end mb-4">
                        <img src="{{ asset('img/13series.jpg') }}" alt="iphone13" class="h-full">
                    </div>
                    <span class="text-sm font-medium text-gray-900">Iphone 13 Series</span>
                    <span class="text-xs text-orange-600 mt-1">Mulai Dari Rp10 ribu</span>
                </div>

                <div class="shrink-0 flex flex-col items-center text-center snap-center group cursor-pointer"
                    onclick="window.location='{{ route('category', 'iphone14') }}'">
                    <div class="h-24 flex items-end mb-4">
                        <img src="{{ asset('img/14series.jpg') }}" alt="iphone14" class="h-full">
                    </div>
                    <span class="text-sm font-medium text-gray-900">iPhone 14 Series</span>
                    <span class="text-xs text-orange-600 mt-1">Mulai Rp10 ribu</span>
                </div>

                <div class="shrink-0 flex flex-col items-center text-center snap-center group cursor-pointer"
                    onclick="window.location='{{ route('category', 'iphone15') }}'">
                    <div class="h-24 flex items-end mb-4">
                        <img src="{{ asset('img/15series.jpg') }}" alt="iphone15" class="h-full">
                    </div>
                    <span class="text-sm font-medium text-gray-900">Iphone 15 Series</span>
                    <span class="text-xs text-orange-600 mt-1">Mulai Rp10 ribu</span>
                </div>

                <div class="shrink-0 flex flex-col items-center text-center snap-center group cursor-pointer"
                    onclick="window.location='{{ route('category', 'iphone16') }}'">
                    <div class="h-24 flex items-end mb-4">
                        <img src="{{ asset('img/16series.png') }}" alt="iphone16" class="h-full">
                    </div>
                    <span class="text-sm font-medium text-gray-900">Iphone 16 Series</span>
                    <span class="text-xs text-orange-600 mt-1">Mulai Rp10 ribu</span>
                </div>

                <div class="shrink-0 flex flex-col items-center text-center snap-center group cursor-pointer"
                    onclick="window.location='{{ route('category', 'iphone17') }}'">
                    <div class="h-24 flex items-end mb-4">
                        <img src="{{ asset('img/17series.png') }}" alt="iphone17" class="h-full">
                    </div>
                    <span class="text-sm font-medium text-gray-900">Iphone 17 Series</span>
                    <span class="text-xs text-orange-600 mt-1">Mulai Rp10 ribu</span>
                </div>

                <div class="shrink-0 flex flex-col items-center text-center snap-center group cursor-pointer"
                    onclick="window.location='{{ route('category', 'g2g') }}'">
                    <div class="h-24 flex items-end mb-4">
                        <img src="{{ asset('img/g2g.jpg') }}" alt="g2g" class="h-full">
                    </div>
                    <span class="text-sm font-medium text-gray-900">G2G</span>
                    <span class="text-xs text-orange-600 mt-1">Mulai Rp10 ribu</span>
                </div>

                <div class="shrink-0 flex flex-col items-center text-center snap-center group cursor-pointer"
                    onclick="window.location='{{ route('category', 'softlens') }}'">
                    <div class="h-24 flex items-end mb-4">
                        <img src="{{ asset('img/softlens.png') }}" alt="softlens" class="h-full">
                    </div>
                    <span class="text-sm font-medium text-gray-900">Softlens</span>
                    <span class="text-xs text-orange-600 mt-1">Mulai Rp10 ribu</span>
                </div>

            </div>
        </div>
    </section>



    <section class="max-w-7xl mx-auto px-4 sm:px-6 py-16 sm:py-20">
        <h2 class="text-center text-2xl sm:text-3xl font-bold mb-8 sm:mb-12">Discover Our Signature Series</h2>

        {{-- Row 1: 2 Large Items --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-3 sm:mb-4">
            {{-- Item 1 --}}
            <div class="signature-card relative overflow-hidden rounded-2xl sm:rounded-[2.5rem] group cursor-pointer shadow-sm transition-all duration-500 hover:shadow-xl reveal-left opacity-0 -translate-x-20 transition-all duration-1000 ease-out"
                onclick="window.location='#'">
                <div class="relative w-full h-[280px] sm:h-[350px] md:h-[420px] lg:h-[480px]">
                    <img src="{{ asset('img/sig3.jpg') }}" alt="Signature 1"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-8 z-10">
                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white mb-1 sm:mb-2">Judul Produk 1</h3>
                        <p class="text-xs sm:text-sm text-white/80 mb-3 sm:mb-5 font-medium">Deskripsi singkat produk 1</p>
                        <span
                            class="inline-block px-6 sm:px-10 py-2 sm:py-2.5 border-2 border-white text-white rounded-full text-xs sm:text-sm font-bold hover:bg-white hover:text-gray-900 transition-all transform group-hover:scale-105">
                            Learn More
                        </span>
                    </div>
                </div>
            </div>

            {{-- Item 2 --}}
            <div class="signature-card relative overflow-hidden rounded-2xl sm:rounded-[2.5rem] group cursor-pointer shadow-sm transition-all duration-500 hover:shadow-xl reveal-right opacity-0 translate-x-20 transition-all duration-1000 ease-out"
                onclick="window.location='#'">
                <div class="relative w-full h-[280px] sm:h-[350px] md:h-[420px] lg:h-[480px]">
                    <img src="{{ asset('img/sig1.webp') }}" alt="Signature 2"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-8 z-10">
                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white mb-1 sm:mb-2">Judul Produk 2</h3>
                        <p class="text-xs sm:text-sm text-white/80 mb-3 sm:mb-5 font-medium">Deskripsi singkat produk 2</p>
                        <span
                            class="inline-block px-6 sm:px-10 py-2 sm:py-2.5 border-2 border-white text-white rounded-full text-xs sm:text-sm font-bold hover:bg-white hover:text-gray-900 transition-all transform group-hover:scale-105">
                            Learn More
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 2: 3 Smaller Items --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
            {{-- Item 3 --}}
            <div class="signature-card relative overflow-hidden rounded-2xl sm:rounded-[2.5rem] group cursor-pointer shadow-sm transition-all duration-500 hover:shadow-xl reveal-left opacity-0 -translate-x-20 transition-all duration-1000 ease-out"
                onclick="window.location='#'">
                <div class="relative w-full h-[250px] sm:h-[280px] md:h-[320px] lg:h-[360px]">
                    <img src="{{ asset('img/sig6.png') }}" alt="Signature 3"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 z-10">
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-white mb-1 sm:mb-2">Judul Produk 3</h3>
                        <p class="text-xs sm:text-sm text-white/80 mb-3 sm:mb-4 font-medium">Deskripsi singkat produk 3</p>
                        <span
                            class="inline-block px-5 sm:px-6 py-1.5 sm:py-2 border-2 border-white text-white rounded-full text-xs font-bold hover:bg-white hover:text-gray-900 transition-all transform group-hover:scale-105">
                            Learn More
                        </span>
                    </div>
                </div>
            </div>

            {{-- Item 4 --}}
            <div class="signature-card relative overflow-hidden rounded-2xl sm:rounded-[2.5rem] group cursor-pointer shadow-sm transition-all duration-500 hover:shadow-xl reveal-right opacity-0 translate-y-20 transition-all duration-1000 ease-out"
                onclick="window.location='#'">
                <div class="relative w-full h-[250px] sm:h-[280px] md:h-[320px] lg:h-[360px]">
                    <img src="{{ asset('img/sig5.jpeg') }}" alt="Signature 4"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 z-10">
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-white mb-1 sm:mb-2">Judul Produk 4</h3>
                        <p class="text-xs sm:text-sm text-white/80 mb-3 sm:mb-4 font-medium">Deskripsi singkat produk 4</p>
                        <span
                            class="inline-block px-5 sm:px-6 py-1.5 sm:py-2 border-2 border-white text-white rounded-full text-xs font-bold hover:bg-white hover:text-gray-900 transition-all transform group-hover:scale-105">
                            Learn More
                        </span>
                    </div>
                </div>
            </div>

            {{-- Item 5 --}}
            <div class="signature-card relative overflow-hidden rounded-2xl sm:rounded-[2.5rem] group cursor-pointer shadow-sm transition-all duration-500 hover:shadow-xl sm:col-span-2 md:col-span-1 reveal-left opacity-0 translate-x-20 transition-all duration-1000 ease-out"
                onclick="window.location='#'">
                <div class="relative w-full h-[250px] sm:h-[280px] md:h-[320px] lg:h-[360px]">
                    <img src="{{ asset('img/sig4.jpg') }}" alt="Signature 5"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 z-10">
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-white mb-1 sm:mb-2">Judul Produk 5</h3>
                        <p class="text-xs sm:text-sm text-white/80 mb-3 sm:mb-4 font-medium">Deskripsi singkat produk 5</p>
                        <span
                            class="inline-block px-5 sm:px-6 py-1.5 sm:py-2 border-2 border-white text-white rounded-full text-xs font-bold hover:bg-white hover:text-gray-900 transition-all transform group-hover:scale-105">
                            Learn More
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section
        class="max-w-7xl mx-auto px-6 py-10 reveal-left opacity-0 translate-y-20 transition-all duration-1000 ease-out">
        <h2 class="text-center text-xl font-semibold mb-8">Jelajahi Aksesoris Iphone</h2>

        <div id="carousel-multi" class="relative" data-carousel="static">
            <!-- Carousel wrapper -->
            <div>
                <!-- Container harus overflow-x-auto dan scroll-smooth -->
                <div class="flex overflow-x-auto scroll-smooth no-scrollbar" data-carousel-items-container>
                    <!-- Items dengan flex: 0 0 20% agar 5 item muncul, tambahkan min-w untuk konsistensi di HP -->
                    <a href="/power-banks" class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Power Banks"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Charger Iphone</span>
                        </div>
                    </a>
                    <a href="/chargers" class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Chargers"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Tempered Glass</span>
                        </div>
                    </a>
                    <a href="{{ route('category', 'iphone13') }}"
                        class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Wireless Chargers"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Iphone 13 Series</span>
                        </div>
                    </a>
                    <a href="{{ route('category', 'iphone14') }}"
                        class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Car Chargers"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Iphone 14 Series</span>
                        </div>
                    </a>
                    <a href="{{ route('category', 'iphone15') }}"
                        class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Power Strip"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Iphone 15 Series</span>
                        </div>
                    </a>
                    <!-- Item 6 -->
                    <a href="{{ route('category', 'iphone16') }}"
                        class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Item 6"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Iphone 16 Series</span>
                        </div>
                    </a>
                    <!-- Item 7 -->
                    <a href="{{ route('category', 'iphone17') }}"
                        class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Item 7"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Iphone 17 Series</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="flex justify-end">
                <a href="#" class="text-sm sm:text-base font-medium hover:underline">
                    See more &gt;
                </a>
            </div>


            <!-- Controls -->
            <button type="button" id="prevBtn"
                class="absolute top-1/2 left-2 -translate-y-1/2 rounded-full bg-white p-2 shadow hover:bg-gray-200 focus:outline-none z-30">
                <span class="sr-only">Previous</span>
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button type="button" id="nextBtn"
                class="absolute top-1/2 right-2 -translate-y-1/2 rounded-full bg-white p-2 shadow hover:bg-gray-200 focus:outline-none z-30">
                <span class="sr-only">Next</span>
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </section>

    <section
        class="max-w-7xl mx-auto px-6 py-10 reveal-left opacity-0 translate-y-20 transition-all duration-1000 ease-out">
        <h2 class="text-center text-xl font-semibold mb-8">Jelajahi Produk Kosmetik</h2>

        <div id="carousel-multi-2" class="relative" data-carousel="static">
            <!-- Carousel wrapper -->
            <div>
                <!-- Container harus overflow-x-auto dan scroll-smooth -->
                <div class="flex overflow-x-auto scroll-smooth no-scrollbar" data-carousel-items-container>
                    <!-- Items dengan flex: 0 0 20% agar 5 item muncul, tambahkan min-w untuk konsistensi di HP -->
                    <a href="{{ route('category', 'softlens') }}"
                        class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Power Banks"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Softlens</span>
                        </div>
                    </a>
                    <a href="{{ route('category', 'g2g') }}"
                        class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Chargers"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">G2G</span>
                        </div>
                    </a>
                    <a href="/wireless-chargers" class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Wireless Chargers"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Brand3</span>
                        </div>
                    </a>
                    <a href="/car-chargers" class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Car Chargers"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Brand4</span>
                        </div>
                    </a>
                    <a href="/power-strip" class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Power Strip"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Brand5</span>
                        </div>
                    </a>
                    <!-- Item 6 -->
                    <a href="/item6" class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Item 6"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Brand6</span>
                        </div>
                    </a>
                    <!-- Item 7 -->
                    <a href="/item7" class="shrink-0 grow-0 basis-1/5 min-w-35 px-2 group cursor-pointer">
                        <div class="rounded-lg p-4 flex flex-col items-center">
                            <img src="{{ asset('img/tes.png') }}" alt="Item 7"
                                class="w-32 h-32 object-contain transition-transform duration-300 ease-in-out group-hover:scale-110" />
                            <span class="mt-3 font-semibold text-center text-gray-900">Brand7</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="flex justify-end">
                <a href="#" class="text-sm sm:text-base font-medium hover:underline">
                    See more &gt;
                </a>
            </div>


            <!-- Controls -->
            <button type="button" id="prevBtn-2"
                class="absolute top-1/2 left-2 -translate-y-1/2 rounded-full bg-white p-2 shadow hover:bg-gray-200 focus:outline-none z-30">
                <span class="sr-only">Previous</span>
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button type="button" id="nextBtn-2"
                class="absolute top-1/2 right-2 -translate-y-1/2 rounded-full bg-white p-2 shadow hover:bg-gray-200 focus:outline-none z-30">
                <span class="sr-only">Next</span>
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </section>

    <section class="py-16 bg-white overflow-hidden">
        <div class="max-w-7xl px-4 mx-auto text-center">

            <h2
                class="mb-6 text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-3xl lg:text-4xl reveal-left opacity-0 translate-x-20 transition-all duration-1000 ease-out">
                Made to Match Your World
            </h2>

            <div class="relative mb-12 reveal-left opacity-0 -translate-x-20 transition-all duration-1000 ease-out">
                <img src="{{ asset('img/tes.png') }}" class="h-auto max-w-full rounded-lg shadow-2xl mx-auto"
                    alt="Workspace Setup">
            </div>

            <div class="max-w-2xl mx-auto reveal-left opacity-0 translate-y-20 transition-all duration-1000 ease-out">
                <span
                    class="inline-block mb-4 text-xs font-bold tracking-widest text-gray-900 uppercase border-b-2 border-green-600 pb-1">
                    HOME
                </span>

                <p class="mb-8 text-lg font-normal text-gray-600 lg:text-xl px-4">
                    From kitchen counter to bedside table, UGREEN gives every corner of your home the power and order it
                    needs, so you can focus on what matters most.
                </p>

                <button type="button"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-8 py-3 me-2 mb-2 transition-all duration-300">
                    Discover Everyday Essentials <span class="ml-2">></span>
                </button>
            </div>

        </div>
    </section>



    <section class="py-20 bg-gray-50 text-center">
        <div class="max-w-7xl px-4 mx-auto">
            <h2 class="reveal-up mb-12 text-3xl font-bold text-gray-900">
                Driven by Innovation
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div
                    class="reveal-up p-8 bg-white shadow-sm reveal-left opacity-0 translate-y-10 transition-all duration-700 delay-100">
                    <p class="text-4xl font-extrabold text-gray-900">1950+</p>
                    <p class="text-sm text-gray-500 uppercase mt-2">Patents</p>
                </div>
                <div
                    class="reveal-up p-8 bg-white shadow-sm reveal-left opacity-0 translate-y-10 transition-all duration-700 delay-200">
                    <p class="text-4xl font-extrabold text-gray-900">180+</p>
                    <p class="text-sm text-gray-500 uppercase mt-2">Countries</p>
                </div>
                <div
                    class="reveal-up p-8 bg-white shadow-sm reveal-left opacity-0 translate-y-10 transition-all duration-700 delay-300">
                    <p class="text-4xl font-extrabold text-gray-900">50+</p>
                    <p class="text-sm text-gray-500 uppercase mt-2">Product Design Awards</p>
                </div>
                <div
                    class="reveal-up p-8 bg-white shadow-sm reveal-left opacity-0 translate-y-10 transition-all duration-700 delay-400">
                    <p class="text-4xl font-extrabold text-gray-900">200M+</p>
                    <p class="text-sm text-gray-500 uppercase mt-2">Global Users</p>
                </div>
            </div>
        </div>
    </section>


    <section class="max-w-7xl mx-auto px-6 py-12">
        <h2 class="text-3xl font-semibold mb-8 reveal-left opacity-0 translate-y-20 transition-all duration-1000 ease-out">
            What the Pros Are Saying
        </h2>

        <div
            class="flex flex-row overflow-x-auto gap-6 lg:grid lg:grid-cols-4 lg:overflow-visible reveal-left opacity-0 translate-x-20 transition-all duration-1000 ease-out">

            <!-- Video Item 1 -->
            <div class="relative group cursor-pointer video-card w-80 shrink-0 lg:w-full" data-video-id="X0porxgyJyg">

                <img src="https://img.youtube.com/vi/X0porxgyJyg/hqdefault.jpg"
                    class="w-full h-96 object-cover rounded-lg">

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/40 rounded-lg"></div>

                <!-- Play Button -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-white/80 p-4 rounded-full group-hover:scale-110 transition">
                        ▶
                    </div>
                </div>

                <!-- Caption -->
                <div class="absolute bottom-4 left-4 text-white">
                    <p class="font-semibold">
                        UGREEN Uno Series Review
                    </p>
                    <span class="text-sm opacity-80">
                        @creatorname
                    </span>
                </div>
            </div>

            <!-- Video Item 2 -->
            <div class="relative group cursor-pointer video-card w-80 shrink-0 lg:w-full" data-video-id="VJdcqjutVtA">

                <img src="https://img.youtube.com/vi/VJdcqjutVtA/hqdefault.jpg"
                    class="w-full h-96 object-cover rounded-lg">

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/40 rounded-lg"></div>

                <!-- Play Button -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-white/80 p-4 rounded-full group-hover:scale-110 transition">
                        ▶
                    </div>
                </div>

                <!-- Caption -->
                <div class="absolute bottom-4 left-4 text-white">
                    <p class="font-semibold">
                        Tech Gadget Unboxing
                    </p>
                    <span class="text-sm opacity-80">
                        @techreviewer
                    </span>
                </div>
            </div>

            <!-- Video Item 3 -->
            <div class="relative group cursor-pointer video-card w-80 shrink-0 lg:w-full" data-video-id="9bZkp7q19f0">

                <img src="https://img.youtube.com/vi/9bZkp7q19f0/hqdefault.jpg"
                    class="w-full h-96 object-cover rounded-lg">

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/40 rounded-lg"></div>

                <!-- Play Button -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-white/80 p-4 rounded-full group-hover:scale-110 transition">
                        ▶
                    </div>
                </div>

                <!-- Caption -->
                <div class="absolute bottom-4 left-4 text-white">
                    <p class="font-semibold">
                        Best Accessories for 2023
                    </p>
                    <span class="text-sm opacity-80">
                        @gadgetguru
                    </span>
                </div>
            </div>

            <!-- Video Item 4 -->
            <div class="relative group cursor-pointer video-card w-80 shrink-0 lg:w-full" data-video-id="kJQP7kiw5Fk">

                <img src="https://img.youtube.com/vi/kJQP7kiw5Fk/hqdefault.jpg"
                    class="w-full h-96 object-cover rounded-lg">

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/40 rounded-lg"></div>

                <!-- Play Button -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-white/80 p-4 rounded-full group-hover:scale-110 transition">
                        ▶
                    </div>
                </div>

                <!-- Caption -->
                <div class="absolute bottom-4 left-4 text-white">
                    <p class="font-semibold">
                        Ultimate Product Comparison
                    </p>
                    <span class="text-sm opacity-80">
                        @reviewmaster
                    </span>
                </div>
            </div>

        </div>
    </section>

    <!-- Modal -->
    <div id="videoModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

        <div class="relative w-full max-w-4xl mx-4">

            <button id="closeModal" class="absolute -top-10 right-0 text-white text-2xl">
                ✕
            </button>

            <div class="aspect-video">
                <iframe id="youtubeFrame" class="w-full h-full rounded-lg" src=""
                    allow="autoplay; encrypted-media" allowfullscreen>
                </iframe>
            </div>

        </div>
    </div>




@endsection


@push('js')
    <script src="{{ asset('assets/home.js') }}"></script>
@endpush

@push('css')
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endpush

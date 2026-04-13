<nav class="bg-neutral-primary-soft border-default fixed top-0 left-0 w-full z-50">
    <div class=" flex flex-wrap justify-between items-center mx-auto max-w-7xl py-2 px-4">
        <a href="https://lfcatalog.jrsept.com" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/logo_lfc.png') }}" class="h-16 max-h-10 object-contain" alt="LF_Catalog Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap text-heading"><img src="{{ asset('img/logo_lfc3.png') }}" class="h-6 object-contain" alt="LF_Catalog Logo" /></span>
        </a>
        <div class="flex items-center gap-2 md:order-2">
            <a href="/cart" class="relative p-2 text-gray-600 hover:text-gray-900 transition" title="Keranjang">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path>
                </svg>
                <span id="cart-badge" class="hidden absolute -top-0.5 -right-0.5 bg-red-600 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">0</span>
            </a>
            <button data-collapse-toggle="mega-menu-full-image" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-lg md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-default"
                aria-controls="mega-menu-full-image" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
            </svg>
        </button>
        </div>
        <div id="mega-menu-full-image" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-8 rtl:space-x-reverse">
                <li>
                    <a href="{{ route('home') }}"
                        class="block py-2 px-3 text-heading hover:text-fg-brand border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0"
                        aria-current="page">Home</a>
                </li>
                <li>
                    <button id="mega-menu-full-cta-image-button" data-collapse-toggle="mega-menu-full-image-dropdown"
                        class="flex items-center justify-between w-full py-2 px-3 font-medium text-heading border-b border-light md:w-auto hover:bg-neutral-secondary-soft hover:text-fg-brand md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                        Kategori
                        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 9-7 7-7-7" />
                        </svg>
                    </button>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 text-heading hover:text-fg-brand border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">Product</a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 text-heading hover:text-fg-brand border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">Resources</a>
                </li>
                <li>
                    <a id="btn-contact" href="#"
                        class="block py-2 px-3 text-heading hover:text-fg-brand border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">Contact</a>
                </li>
            </ul>
        </div>
    </div>
    <div id="mega-menu-full-image-dropdown"
        class=" hidden mt-1 bg-neutral-primary-soft border-default shadow-xs border-y">
        <div class="grid max-w-7xl px-4 py-5 mx-auto text-sm text-body md:grid-cols-3 md:px-6 gap-6">
            {{-- Column 1: Aksesoris iPhone --}}
            <div>
                <h3 class="mb-3 font-bold text-heading text-base">Aksesoris iPhone</h3>
                <ul class="space-y-3" aria-labelledby="mega-menu-full-image-button">
                    <li>
                        <a href="{{ route('category', 'iphone13')}}" class="hover:underline hover:text-fg-brand">
                            iPhone 13 Series
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category', 'iphone14') }}" class="hover:underline hover:text-fg-brand">
                            iPhone 14 Series
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category', 'iphone15') }}" class="hover:underline hover:text-fg-brand">
                            iPhone 15 Series
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category', 'iphone16') }}" class="hover:underline hover:text-fg-brand">
                            iPhone 16 Series
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category', 'iphone17') }}" class="hover:underline hover:text-fg-brand">
                            iPhone 17 Series
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category', 'charger') }}" class="hover:underline hover:text-fg-brand">
                            Charger
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category', 'temperedglass') }}" class="hover:underline hover:text-fg-brand">
                            Tempered Glass
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Column 2: Sport --}}
            <div>
                {{-- Sport Basket - Hidden: produk belum ready
                <h3 class="mb-3 font-bold text-heading text-base">Sport Basket</h3>
                <ul class="space-y-3 mb-6">
                    <li>
                        <a href="{{ route('category', 'sepatubs') }}" class="hover:underline hover:text-fg-brand">
                            Sepatu Basket
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category', 'kaoskakibs') }}" class="hover:underline hover:text-fg-brand">
                            Kaos Kaki Basket
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category', 'bajubs') }}" class="hover:underline hover:text-fg-brand">
                            Baju Basket
                        </a>
                    </li>
                </ul>
                --}}
                <h3 class="mb-3 font-bold text-heading text-base">Sport Futsal</h3>
                <ul class="space-y-3">
                    <li>
                        <span class="text-gray-400">Kaos Kaki</span>
                    </li>
                    <li>
                        <span class="text-gray-400">Sepatu</span>
                    </li>
                    <li>
                        <span class="text-gray-400">Baju</span>
                    </li>
                </ul>
            </div>

            {{-- Column 3: Fashion & Cosmetik --}}
            <div>
                <h3 class="mb-3 font-bold text-heading text-base">Fashion Pria</h3>
                <ul class="space-y-3 mb-6">
                    <li>
                        <span class="text-gray-400">Baju</span>
                    </li>
                    <li>
                        <span class="text-gray-400">Sendal</span>
                    </li>
                    <li>
                        <span class="text-gray-400">Jaket</span>
                    </li>
                </ul>
                <h3 class="mb-3 font-bold text-heading text-base">Cosmetik G2G</h3>
                <ul class="space-y-3">
                    <li>
                        <span class="text-gray-400">Facewash</span>
                    </li>
                    <li>
                        <span class="text-gray-400">Moisturizer</span>
                    </li>
                    <li>
                        <span class="text-gray-400">Serum</span>
                    </li>
                    <li>
                        <span class="text-gray-400">Cleanser</span>
                    </li>
                    <li>
                        <span class="text-gray-400">Toner</span>
                    </li>
                    <li>
                        <span class="text-gray-400">Body Lotion</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
{{-- <br><br> --}}


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactBtn = document.getElementById('btn-contact');
        contactBtn.addEventListener('click', function(e) {
            e.preventDefault(); // cegah default link
            const footer = document.getElementById('footer');
            if (footer) {
                footer.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
</script>

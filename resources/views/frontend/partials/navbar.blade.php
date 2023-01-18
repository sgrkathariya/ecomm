<style>
    .dropdown:hover>.dropdown-menu {
        display: block;
    }

    .category-dropdown-menu {
        z-index: 999;
    }

    .category-dropdown-menu[data-show] {
        display: block;
    }
</style>
<nav class="hidden md:block text-dark">
    <div class="container text-sm font-semibold tracking-wider">
        <ul class="flex border-b-2 border-primary divide-x">
            <li id="megamenu-toggler" class="bg-primary text-white dropdown relative">
                <div class="px-3 block">
                    <div class="py-2 px-3 pl-0">
                        <span class="flex items-center">
                            <svg class="h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <span class="uppercase">All Products</span>
                        </span>
                    </div>
                </div>

                <div class="category-level-one-wrapper dropdown-menu absolute inset-x-0  hidden pt-1 shadow-xl"
                    style="z-index: 999">
                    <x-multilevel-category-menu />
                </div>


                {{-- <div class="dropdown-menu absolute left-0 right-0 hidden" style="z-index: 999">
                    <div class="container mx-auto text-gray-900">
                        <div class="p-4 rounded-b border border-gray-200 font-sans" style="background-color: #f5f5f5;">
                            <div class="grid grid-cols-3 gap-4">
                                @foreach (\App\Category::with('childcategories.childcategories')->where('parent_id', null)->active()->orderBy('name')->get() as $category)
                                <div>
                                    <div class="font-semibold mb-2 uppercase text-main-500">{{ $category->name }}</div>
                                    @foreach ($category->childcategories as $category)
                                    <div class="text-sm font-normal space-y-1">
                                        <a href="#">{{ ucfirst($category->name)}}</a>
                                        <div class="pl-2 space-y-1">
                                            @foreach ($category->childcategories as $category)
                                            <div class="">
                                                <a class="" href="{{ route('frontend.products.index', ['category' => $category->slug]) }}">{{ ucfirst($category->name) }}</a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div> --}}

            </li>
            <x-category-menu-view />

            <li id="megamenu-toggler" class="dropdown relative">
                <div class="px-3 block">
                    <div class="py-2 px-3 pl-0">
                        <span class="flex items-center">
                            <span class="px-2">Brand</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="category-level-one-wrapper dropdown-menu absolute inset-x-0  hidden pt-1 shadow-xl"
                    style="z-index: 999">
                    <x-brand-menu />
                </div>
            </li>
            <li class="px-5">
                <a class="inline-block py-2 px-3 hover:text-primary border-b border-transparent hover:border-theme-red "
                    href="{{ route('frontend.pages.show', 'about-us') }}">About-Us</a>
            </li>
            <li class="px-5">
                <a class="inline-block py-2 px-3 hover:text-primary border-b border-transparent hover:border-theme-red "
                    href="{{ route('frontend.contact-form.index') }}">Contact-Us</a>
            </li>
        </ul>
    </div>
</nav>
{{-- @push('scripts')
    <script>
        let megamenuToggler = document.getElementById('megamenu-toggler');
        megamenuToggler.addEventListener('mouseover', function() {
            alert();
        });
    </script>
@endpush --}}

@foreach ($categoryMenus as $categoryMenu)
    <li id="megamenu-toggler" class="dropdown relative">
        <div class="px-3 block">
            <div class="py-2 px-3 pl-0">
                <span class="flex items-center">
                    <a class="flex-grow"
                        href="{{ route('frontend.products.index', ['category' => $categoryMenu->category->slug]) }}"><span
                            class="uppercase px-2">{{ $categoryMenu->display_name }}</span></a>
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
            <div class="text-xs border">
                @foreach ($categories as $category)
                    @if ($categoryMenu->category_id == $category->id)
                        @foreach ($category->childcategories as $category)
                            <div class="category-dropdown-item">
                                <div class="category-dropdown relative flex justify-between bg-white text-gray-800 items-center hover:bg-theme-red hover:bg-main-50 whitespace-no-wrap">
                                    <a class="category-dropdown-link flex px-3 py-2 text-gray-800 whitespace-no-wrap hover:bg-theme-red hover:bg-main-50" href="{{ route('frontend.products.index', ['category' => $category->slug]) }}">{{ ucfirst($category->name) }}</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
                @push('scripts')
                    <script>
                        $(function() {
                            $('.category-dropdown').each(function(_, dropdown) {
                                const dropdownMenu = $(dropdown).find('> .category-dropdown-menu')[0];
                                let popperInstance = null;

                                function create() {
                                    popperInstance = Popper.createPopper(dropdown, dropdownMenu, {
                                        placement: 'auto-start',
                                        strategy: 'absolute',
                                        modifiers: [{
                                            name: 'flip',
                                            options: {
                                                fallbackPlacements: ['top', 'bottom', 'left', 'right'],
                                            }
                                        }]
                                    });
                                }

                                function destroy() {
                                    if (popperInstance) {
                                        popperInstance.destroy();
                                        popperInstance = null;
                                    }
                                }

                                function show() {
                                    console.log('showing menu');
                                    $(dropdownMenu).attr('data-show', '');
                                    create();
                                }

                                function hide() {
                                    console.log('hiding menu');
                                    $(dropdownMenu).removeAttr('data-show');
                                    destroy();
                                }

                                $(dropdown).on('mouseenter', show);
                                $(dropdown).on('mouseleave', hide);

                            });
                        });
                    </script>
                @endpush
            </div>
        </div>
    </li>
@endforeach

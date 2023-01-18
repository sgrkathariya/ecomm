<div class="text-xs border">
    @foreach ($brands as $brand)
        <div
            class="brand-dropdown relative flex justify-between px-1 py-2 bg-white text-gray-800 items-center hover:bg-theme-red hover:bg-main-50 hover:text-primary whitespace-no-wrap w-full">
            <a class="inline-block px-1 hover:text-primary border-b border-transparent hover:border-theme-red "
                href="{{ route('frontend.products.index', ['brand' => $brand->slug]) }}">
                <span>{{ $brand->name }}</span>
            </a>
        </div>
    @endforeach

    @push('scripts')
        <script>
            $(function() {
                $('.brand-dropdown').each(function(_, dropdown) {
                    const dropdownMenu = $(dropdown).find('> .brand-dropdown-menu')[0];
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

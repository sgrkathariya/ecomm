@extends('layouts.app')
@push('styles')
    <style>
        @media only screen and (min-width: 600px) {
            .magnify-detail::before {
                display: none;
            }
        }

        .swiper-slide {
            flex-shrink: 1;
            width: 30%;
            height: 100%;
        }

        .magnify-detail {
            height: 90%;
        }

        /* #product__full_image {
                                                                                                                width: 100%;
                                                                                                                height: 400px;
                                                                                                            } */
    </style>
@endpush

@section('breadcrumbs')
    {{ Breadcrumbs::render('single-product', $product) }}
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="bg-white my-5">
            <div class="grid grid-cols-12 gap-4 lg:gap-5 xl:gap-8">
                <div class="col-span-12 sm:col-span-4">
                    {{-- Product Images --}}
                    <img id="product__full__image" class="magnify w-auto h-56 md:w-auto md:h-72 lg:h-96 object-cover mx-auto"
                        src="{{ $product->featured_image_url }}" alt="{{ $product->name }}"
                        data-zoom="{{ $product->featured_image_url }}">
                    <div class="swiper-container product__image__roll rounded-sm py-2 w-full bg-gray-100 px-2 shadow-xs">
                        {{-- <div class="swiper-pagination"></div> --}}
                        <div class="swiper-wrapper">
                            <img class="swiper-slide h-10 md:h-12 w-auto border border-transparent opacity-75 hover:border-theme-red hover:opacity-100 transform -translate-y-1 cursor-pointer"
                                src="{{ $product->medium_featured_image_url }}">
                            @foreach ($product->productImages as $image)
                                <img class="swiper-slide h-10 md:h-12 w-auto border border-transparent opacity-75 hover:border-theme-red hover:opacity-100 cursor-pointer"
                                    src="{{ $image->medium_thumbnail_url }}">
                            @endforeach
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>

                    {{-- End of product images --}}
                </div>
                <div class="col-span-12 sm:col-span-8 font-nunito">
                    <div class="relative magnify-detail">
                        <h1 class="text-lg text-gray-900 font-semibold font-lato mb-3 mt-3 sm:mt-0">{{ $product->name }}
                        </h1>
                        @mobile
                            <div class="flex bg-main-600 p-3 rounded text-white">
                                <div>
                                    <h1 class="text-2xl font-semibold text-white">
                                        {{ priceUnit() }}
                                        {{ number_format($product->hasDiscount() ? $product->sale_price : $product->regular_price) }}
                                    </h1>
                                    <div class="flex items-center space-x-2">
                                        @if ($product->hasDiscount())
                                            <h3 class="text-lg font-normal text-gray-100 line-through">{{ priceUnit() }}
                                                {{ number_format($product->regular_price) }}</h3>
                                        @endif
                                        @if ($product->hasDiscount())
                                            <span class="text-sm text-white">({{ $product->discountPercentage() }} off)</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    @include('frontend.product.__ratings_rate')
                                </div>
                            </div>
                        @endmobile



                        @hasanyrole('admin|seller')
                            <a class="text-blue-600 hover:underline" href="{{ route('products.edit', $product) }}">Edit</a>
                        @endhasanyrole
                        {{-- brand --}}
                        <div class="text-sm text-gray-800 mb-3">Brand: <a class="text-primary"
                                href="{{ route('frontend.products.index', ['brand' => $product->brand->slug]) }}">{{ $product->brand->name }}</a>
                        </div>
                        @desktop
                            <div class="pb-2">
                                <span
                                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-800 mr-2 mb-2">#
                                    {{ $product->category->name }}</span>
                            </div>
                            {{-- Ratings & Rate --}}
                            @include('frontend.product.__ratings_rate')
                            <div class="flex items-center space-x-2">
                                @if ($product->hasDiscount())
                                    <h3 class="text-lg font-normal text-gray-700 line-through">{{ priceUnit() }}
                                        {{ number_format($product->regular_price) }}</h3>
                                @endif
                                <h1 class="text-2xl font-semibold text-primary">
                                    {{ priceUnit() }}
                                    {{ number_format($product->hasDiscount() ? $product->sale_price : $product->regular_price) }}
                                </h1>
                                @if ($product->hasDiscount())
                                    <span class="text-sm text-gray-700">({{ $product->discountPercentage() }} off)</span>
                                @endif
                            </div>
                        @enddesktop
                        @if ($product->sku)
                            <div class="text-sm text-gray-800 mb-3">SKU: {{ $product->sku }}</div>
                        @endif
                        @if ($product->purchase_note)
                            <div class="bg-green-200 text-green-800 text-sm p-3 border-t border-b border-green-500">
                                {{ $product->purchase_note }}
                            </div>
                        @endif

                        <div class="mt-3">
                            <x-whats-app-chat />
                        </div>
                        <div class="flex space-x-5">
                            <livewire:add-to-cart-button :product="$product" :withQuantity="is_desktop() ? true : false" />
                            <livewire:add-to-cart-button :product="$product" buyNow="true" />
                        </div>

                        @if ($product->hasLimitedStock())
                            <div class="text-secondary leading-8">
                                @if ($product->stock_quantity && $product->stock_quantity <= limitedStockThreshold())
                                    <span>Only {{ $product->stock_quantity }} in stock </span>
                                @else
                                    <div class="flex items-center space-x-1 text-primary text-xs font-semibold">
                                        <span class="text-yellow-600">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </span>
                                        <span>Low on stock</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <livewire:wishlist-button :product="$product" />

                        <div class="flex flex-nowrap space-x-5 my-3">
                            <div>Share:</div>
                            <div>
                                <a href="https://facebook.com/share.php?u={{ URL::current() }}" target="_blank"
                                    rel="noopener noreferrer">
                                    <span class="text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div>
                                <a href="http://www.twitter.com/share?url={{ URL::current() }}" target="_blank"
                                    title="shere by twitter">
                                    <span class="text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                            <path
                                                d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                        </svg>
                                    </span>
                                </a>

                            </div>
                            <div>
                                <a href="https://api.whatsapp.com/send?text={{ URL::current() }}"
                                    data-action="share/whatsapp/share" target="_blank">
                                    <span class="text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                            <path
                                                d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div>
                                <a href="mailto:?subject=Check out&amp;body=Check out this site {{ URL::current() }}"
                                    title="shere by email" target="_blank">
                                    <span class="text-amber-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <path
                                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-4"></div>

        {{-- Product details card --}}
        <div class="break-words">
            <h4 class="text-primary text-lg py-2 px-4 font-semibold">Product Details of {{ $product->name }}</h4>
            <div class="px-2 sm:px-4">
                <div class="flex flex-col divide-y">
                    @if ($product->product_highlights)
                        <div class="py-3">
                            <ul class="list-inside list-disc grid grid-cols-2">
                                @foreach (explode(',', $product->product_highlights) as $highlight)
                                    <li>{{ $highlight }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($product->product_weight || $product->product_length || $product->product_width || $product->product_height)
                        <div class="text-sm font-nunito py-3">
                            @if ($product->product_weight)
                                <div>Product Weight: {{ $product->product_weight }} </div>
                            @endif
                            @if ($product->product_length || $product->product_width || $product->product_height)
                                <div>Dimension: {{ $product->product_length }} x {{ $product->product_width }} x
                                    {{ $product->product_height }} </div>
                            @endif
                        </div>
                    @endif

                    <div class="py-3 font-roboto">
                        <div class="overflow-x-auto">
                            {!! $product->description !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- End of Product details card --}}

        <div class="my-4"></div>

        {{-- Ratings and Reviews --}}
        <livewire:ratings-and-reviews-box :product='$product' />
        {{-- End of Ratings and Reviews --}}

        <x-product-suggestion-grid title="Similar Products" :products="$relatedProducts" />
    </div>
@endsection

@push('scripts')
    <script>
        $('.product__image__roll img').click(function() {
            console.log($(this).attr('src'));
            $('#product__full__image').attr('src', $(this).attr('src'));
            $('#product__full__image').attr('data-zoom', $(this).attr('src'));
        });


        new Swiper('.product__image__roll', {
            slidesPerView: 'auto',
            speed: 400,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                type: 'progressbar',
            }

            ,
        });


        const driftOptions = {
            paneContainer: document.querySelector('.magnify-detail'),
            zoomFactor: 3,
            inlinePane: 700,
            inlineOffsetX: 100,
            inlineOffsetY: 0,
            handleTouch: false,
            hoverBoundingBox: true
        };

        const handleChange = () => {
            requestAnimationFrame(() => {
                if ($(window).width() <= 600 && !!window.productZoom) {
                    window.productZoom.destroy();
                } else {
                    window.productZoom = new Drift(document.querySelector('.magnify'), driftOptions);
                }
            })
        }

        window.addEventListener('resize', handleChange);
        window.addEventListener('load', handleChange);
    </script>
@endpush

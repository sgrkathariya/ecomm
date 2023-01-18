<div class="bg-white  p-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-4">
    @foreach ($categories as $category)
        <div class="product__card m-3 flex flex-col bg-white shadow-sm hover:shadow">
            <div class="relative">
                <div class="product__image__wrapper overflow-hidden">
                    <a href="{{ route('frontend.products.index', ['category' => $category->slug]) }}"
                        class="aspect-h-6 aspect-w-6 block">
                        <img class="product__image w-full h-full hover-img rounded-t object-contain transform duration-300 hover:scale-105"
                            src="{{ asset('storage/' . $category->thumbnail) }}" alt="{{ $category->name }}"
                            loading="lazy" />
                    </a>
                </div>
            </div>
            <div class="grid h-full py-2 px-2">
                <div class="sm:mt-3">
                    <h5 class="font-normal text-sm text-gray-900 text- leading-5 font-sans hover:text-indigo-700 text-center"
                        style="display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;">
                        <a
                            href="{{ route('frontend.products.index', ['category' => $category->slug]) }}">{{ ucfirst($category->name) }}</a>
                    </h5>
                </div>
            </div>
        </div>
    @endforeach
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
</div>

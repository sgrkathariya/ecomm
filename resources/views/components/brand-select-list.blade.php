<ul>
    @php
        $i = 1;
    @endphp
    @foreach ($brands as $brand)
        <li>
            <a href="{{ request()->fullUrlWithQuery(['brand' => $brand->slug]) }}">
                {{ ucfirst($brand->name) }}
            </a>
       
        </li>
    @endforeach
</ul>

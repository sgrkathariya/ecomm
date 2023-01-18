<div>
    <style>
        .follow svg{
            height: 30px;
            width: 30px;
        }
    </style>
    <h1 class="heading font-lato">Follow Us On</h1>
    {{-- <div class="heading-divider"></div> --}}
    <div class="content">
        <p>
        <ul class="flex items-center space-x-3 mt-4">
            @foreach ($socialMedias as $socialMedia)
                <li><a href="{{ $socialMedia->url }}" alt="{{ $socialMedia->name }}"
                        style="color:{{ $socialMedia->color }};">
                        <span  class="follow">
                            {!! $socialMedia->icon !!}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
        </p>
    </div>
</div>

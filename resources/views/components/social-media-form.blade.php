<div class="card z-depth-0">
    <div class="card-body">
        <div class="d-flex">
            <h5 class="h5-responsive d-inline-block">
                {{ $socialMedia->exists ? 'Edit Social Media' : 'Add new Social Media' }}</h5>
            @if ($socialMedia->exists)
                <a class="btn btn-primary btn-sm my-0 ml-auto" href="{{ route('social-medias.index') }}">Add New</a>
            @endif
        </div>
        <form
            action="{{ $socialMedia->exists ? route('social-medias.update', $socialMedia) : route('social-medias.store') }}"
            method="POST" class="form" enctype="multipart/form-data">
            @csrf
            @if ($socialMedia->exists)
                @method('put')
            @endif
            <x-form.form-group for="name">
                <x-form.label class="required">Name</x-form.label>
                <x-fields.text name="name" :value="old('name', $socialMedia->name)" />
            </x-form.form-group>
            <x-form.form-group for="url">
                <x-form.label class="required">URL</x-form.label>
                <i>https://example.com</i>
                <x-fields.text name="url" :value="old('url', $socialMedia->url)" />
            </x-form.form-group>

            <x-form.form-group for="color">
                <label for="color" class="required">Color</label>
                <input type="color" name="color" value="{{ old('color', $socialMedia->color) }}">
            </x-form.form-group>

            <x-form.form-group for="icon">
                <label for="icon" class="required">Icon</label>
                <textarea name="icon" class="form-control {{ invalid_class('icon') }}" rows="5">{{ old('icon', $socialMedia->icon) }}</textarea>
                <x-invalid-feedback field="icon"></x-invalid-feedback>
                <i>Note: Icon From <a href="https://icons.getbootstrap.com/" target="_blank"
                        rel="noopener noreferrer">icons.getbootstrap.com</a></i>
            </x-form.form-group>

            <div class="form-group">
                <button type="submit"
                    class="btn btn-primary z-depth-0 text-capitalize">{{ $socialMedia->exists ? 'Update Social Media' : 'Add new Social Media' }}</button>
            </div>
        </form>
    </div>
</div>

<div class="card z-depth-0">
    <div class="card-body">
        <div class="d-flex">
            <h5 class="h5-responsive d-inline-block">{{ $brand->exists ? 'Edit brand' : 'Add new brand' }}</h5>
            @if ($brand->exists)
                <a class="btn btn-primary btn-sm my-0 ml-auto" href="{{ route('brands.index') }}">Add New</a>
            @endif
        </div>
        <form action="{{ $brand->exists ? route('brands.update', $brand) : route('brands.store') }}" method="POST"
            class="form" enctype="multipart/form-data">
            @csrf
            @if ($brand->exists)
                @method('put')
            @endif
            <x-form.form-group for="name">
                <x-form.label class="required">Name</x-form.label>
                <x-fields.text name="name" :value="old('name', $brand->name)" />
            </x-form.form-group>

            <x-form.form-group for="thumbnail">
                <label for="thumbnail" class="required">Brand Logo</label>
                <div class="custom-file">
                    <input type="file" name="thumbnail" class="custom-file-input" id="brand-logo-input"
                        aria-describedby="brand-logo-prepend" accept="image/*">
                    <label class="custom-file-label" for="brand-logo-input">Choose file</label>
                </div>
            </x-form.form-group>
            @if ($brand->exists)
                <x-form.form-group label="Slug">
                    <x-fields.text name="slug" :value="old('slug', $brand->slug)" />
                </x-form.form-group>
            @endif
            <x-form.form-group label="Description">
                <textarea name="description" class="form-control {{ invalid_class('description') }}" rows="5">{{ old('description', $brand->description) }}</textarea>
                <x-invalid-feedback field="description"></x-invalid-feedback>
            </x-form.form-group>

            <div class="form-group">
                <button type="submit"
                    class="btn btn-primary z-depth-0 text-capitalize">{{ $brand->exists ? 'Update brand' : 'Add new brand' }}</button>
            </div>

        </form>
    </div>
</div>

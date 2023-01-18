@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <section class="mb-4">
            <div class="flex items-center mb-4 sm:mb-6">
                <h2 class="tracking-wide text-lg">Shop by Brand</h2>
            </div>
            <x-brand-card />
        </section>
    </div>
@endsection

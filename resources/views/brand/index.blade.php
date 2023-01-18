@extends('layouts.admin')

@section('content')
    <div>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Brands</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Brands</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        @include('alerts.all')
        <div class="row">
            <div class="col-md-4">
                <x-brand-form :brand="$brand" />
            </div>
            <div class="col-md-8">
                <div class="card z-depth-0">
                    <div class="card-body">
                        <table class="table table-hover table-responsive-sm">
                            <tr class="text-uppercase font-poppins">
                                <th>Thumbnail</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            <tbody>
                                @forelse($brands as $brand)
                                    <tr>
                                        <td> <img src="{{ asset('storage/' . $brand->thumbnail) }}" alt="logo"
                                                style="max-width: 30px; max-height: 20px">
                                        </td>
                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $brand->slug }}</td>

                                        <td>
                                            <livewire:brand-status-switch :brand="$brand" />
                                        </td>
                                        <td class="text-right">
                                            <div>
                                                <a type="button" class="text-primary" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <span class="svg-icon svg-baseline">
                                                        @include('svg.verticle-dots')
                                                    </span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="{{ route('brands.edit', $brand) }}">Edit</a>
                                                    <form class="form-inline d-inline"
                                                        action="{{ route('brands.destroy', $brand) }}"
                                                        onsubmit="return confirm('Are you sure to delete ?')"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="dropdown-item">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="42" class="font-italic text-center">No Record Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Edit Gallery')

@section('content')

<a href="{{ route('admin.gallery.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Gallery
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Edit Gallery</h1>
    <p>Perbarui informasi gallery <strong>{{ $gallery->nama }}</strong>.</p>
</div>


<div class="admin-card" data-aos="fade-up">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.gallery._form')
        </form>

    </div>
</div>

@endsection
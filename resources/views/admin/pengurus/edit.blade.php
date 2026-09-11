@extends('layouts.admin')

@section('title', 'Edit Pengurus')

@section('content')

<a href="{{ route('admin.pengurus.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Pengurus
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Edit Pengurus</h1>
    <p>Perbarui informasi <strong>{{ $pengurus->nama }}</strong>.</p>
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

        <form
            method="POST"
            action="{{ route('admin.pengurus.update', $pengurus) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            @include('admin.pengurus._form', [
                'buttonText' => 'Simpan Perubahan',
            ])
        </form>

    </div>
</div>

@endsection
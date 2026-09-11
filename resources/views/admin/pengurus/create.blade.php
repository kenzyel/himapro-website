@extends('layouts.admin')

@section('title', 'Tambah Pengurus')

@section('content')

<a href="{{ route('admin.pengurus.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Pengurus
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Tambah Pengurus</h1>
    <p>Tambahkan anggota baru ke struktur organisasi.</p>
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
            action="{{ route('admin.pengurus.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            @include('admin.pengurus._form', [
                'buttonText' => 'Simpan Pengurus',
            ])
        </form>

    </div>
</div>

@endsection
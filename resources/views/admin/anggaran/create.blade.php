@extends('layouts.admin')

@section('title', 'Tambah Anggaran')

@section('content')

<a href="{{ route('admin.anggaran.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Anggaran
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Tambah Anggaran</h1>
    <p>Tambahkan perencanaan anggaran baru.</p>
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

        <form action="{{ route('admin.anggaran.store') }}" method="POST">
            @csrf

            @include('admin.anggaran._form')
        </form>

    </div>
</div>

@endsection
@extends('layouts.admin')

@section('title', 'Tambah Transaksi')

@section('content')

<a href="{{ route('admin.keuangan.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Keuangan
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Tambah Transaksi</h1>
    <p>Catat transaksi keuangan baru.</p>
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

        <form action="{{ route('admin.keuangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.keuangan._form')
        </form>

    </div>
</div>

@endsection
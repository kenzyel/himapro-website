@extends('layouts.admin')

@section('title', 'Tambah Departemen')

@section('content')

<a href="{{ route('admin.departemen.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Departemen
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Tambah Departemen</h1>
    <p>Tambahkan departemen baru ke struktur HIMAPRO TI SAKTI.</p>
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

        <form action="{{ route('admin.departemen.store') }}" method="POST">
            @csrf

            @include('admin.departemen._form')
        </form>

    </div>
</div>

@endsection
@extends('layouts.admin')

@section('title', 'Tambah Program Kerja')

@section('content')

<a href="{{ route('admin.program-kerja.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Program Kerja
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Tambah Program Kerja</h1>
    <p>Tambahkan program kerja baru HIMAPRO TI SAKTI.</p>
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

        <form action="{{ route('admin.program-kerja.store') }}" method="POST">
            @csrf

            @include('admin.program-kerja._form')
        </form>

    </div>
</div>

@endsection
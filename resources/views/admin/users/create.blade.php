@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')

<a href="{{ route('admin.users.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke User
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Tambah User</h1>
    <p>Tambahkan akun pengguna baru ke sistem.</p>
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

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.users._form', ['isEdit' => false])
        </form>

    </div>
</div>

@endsection
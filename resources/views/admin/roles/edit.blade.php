@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')

<a href="{{ route('admin.roles.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Role
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Edit Role</h1>
    <p>Perbarui role <strong>{{ $role->name }}</strong>.</p>
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

        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.roles._form')
        </form>

    </div>
</div>

@endsection
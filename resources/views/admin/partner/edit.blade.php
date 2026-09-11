@extends('layouts.admin')

@section('title', 'Edit Partner')

@section('content')

<a href="{{ route('admin.partner.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Partner
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Edit Partner</h1>
    <p>Perbarui informasi partner <strong>{{ $partner->nama }}</strong>.</p>
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

        <form action="{{ route('admin.partner.update', $partner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.partner._form')
        </form>

    </div>
</div>

@endsection
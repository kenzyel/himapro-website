@extends('layouts.admin')

@section('title', 'Edit Agenda')

@section('content')

<a href="{{ route('admin.agenda.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Agenda
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Edit Agenda</h1>
    <p>Perbarui informasi agenda <strong>{{ $agenda->judul }}</strong>.</p>
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

        <form action="{{ route('admin.agenda.update', $agenda) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.agenda._form')
        </form>

    </div>
</div>

@endsection
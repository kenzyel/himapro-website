@extends('layouts.admin')

@section('title', $pesan->subjek)

@section('content')

<a href="{{ route('admin.pesan.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Pesan
</a>

<div class="page-header" data-aos="fade-down">
    <h1>{{ $pesan->subjek }}</h1>
    <p>Pesan dari {{ $pesan->nama }}.</p>
</div>


@if (session('success'))
    <div class="alert alert-success alert-dismissible" data-aos="fade-down">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif


<div class="row g-4">

    {{-- ISI PESAN --}}
    <div class="col-lg-8">

        <div class="admin-card" data-aos="fade-up">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h2 class="admin-card-title">Isi Pesan</h2>

                @switch($pesan->status)
                    @case('unread')
                        <span class="badge-himapro badge-yellow">
                            <i class="bi bi-envelope-fill"></i> Belum Dibaca
                        </span>
                        @break
                    @case('read')
                        <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">
                            <i class="bi bi-envelope-open-fill"></i> Dibaca
                        </span>
                        @break
                    @case('replied')
                        <span class="badge-himapro badge-active">
                            <i class="bi bi-reply-fill"></i> Dibalas
                        </span>
                        @break
                    @case('archived')
                        <span class="badge-himapro" style="background: rgba(255,255,255,.05); color: var(--muted); border-color: var(--border);">
                            <i class="bi bi-archive-fill"></i> Diarsipkan
                        </span>
                        @break
                @endswitch
            </div>

            <div class="card-body">

                <div class="info-block">
                    <div class="info-block-label">Dari</div>
                    <div class="d-flex align-items-center gap-3 mt-1">
                        <span class="avatar-initials" style="width: 48px; height: 48px; font-size: 18px;">
                            {{ strtoupper(substr($pesan->nama, 0, 1)) }}
                        </span>
                        <div>
                            <div style="font-weight: 700; font-size: 14px;">
                                {{ $pesan->nama }}
                            </div>
                            <div style="font-size: 12px; color: var(--muted);">
                                {{ $pesan->email }}
                                @if ($pesan->telepon)
                                    · {{ $pesan->telepon }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Subjek</div>
                    <div class="info-block-value">{{ $pesan->subjek }}</div>
                </div>

                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Pesan</div>
                    <div style="
                        margin-top: 10px;
                        padding: 18px 20px;
                        background: rgba(255,255,255,.02);
                        border: 1px solid var(--border);
                        border-radius: var(--radius);
                        color: var(--text);
                        font-size: 14px;
                        line-height: 1.8;
                        white-space: pre-line;
                    ">{{ $pesan->pesan }}</div>
                </div>

            </div>
        </div>


        {{-- AKSI CEPAT --}}
        <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header">
                <h2 class="admin-card-title">Tindakan</h2>
                <p class="card-subtitle">Kelola status dan tanggapan pesan</p>
            </div>
            <div class="card-body">

                <div class="d-flex flex-wrap gap-2 mb-3">

                    {{-- BALAS VIA EMAIL --}}
                    <a
                        href="mailto:{{ $pesan->email }}?subject=Re: {{ urlencode($pesan->subjek) }}"
                        class="btn-himapro btn-himapro-primary"
                    >
                        <i class="bi bi-reply-fill"></i>
                        Balas via Email
                    </a>

                    {{-- TANDAI DIBALAS --}}
                    @if ($pesan->status !== 'replied')
                        <form action="{{ route('admin.pesan.update-status', $pesan) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="replied">
                            <button type="submit" class="btn-himapro btn-himapro-secondary">
                                <i class="bi bi-check2-circle"></i>
                                Tandai Sudah Dibalas
                            </button>
                        </form>
                    @endif

                    {{-- ARSIPKAN --}}
                    @if ($pesan->status !== 'archived')
                        <form action="{{ route('admin.pesan.update-status', $pesan) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="archived">
                            <button type="submit" class="btn-himapro btn-himapro-secondary">
                                <i class="bi bi-archive-fill"></i>
                                Arsipkan
                            </button>
                        </form>
                    @endif

                </div>

                {{-- STATUS DROPDOWN --}}
                <form action="{{ route('admin.pesan.update-status', $pesan) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <label for="status" class="form-label">Ubah Status</label>
                    <div class="d-flex gap-2">
                        <select name="status" id="status" class="form-select" style="max-width: 220px;">
                            <option value="unread" @selected($pesan->status === 'unread')>Belum Dibaca</option>
                            <option value="read" @selected($pesan->status === 'read')>Sudah Dibaca</option>
                            <option value="replied" @selected($pesan->status === 'replied')>Sudah Dibalas</option>
                            <option value="archived" @selected($pesan->status === 'archived')>Diarsipkan</option>
                        </select>

                        <button type="submit" class="btn-himapro btn-himapro-primary">
                            <i class="bi bi-check-lg"></i>
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>


    {{-- INFO PENGIRIM --}}
    <div class="col-lg-4">

        <div class="admin-card" data-aos="fade-up" data-aos-delay="150">
            <div class="card-header">
                <h2 class="admin-card-title">Informasi Pesan</h2>
            </div>
            <div class="card-body">

                <div class="info-block">
                    <div class="info-block-label">Status</div>
                    <div>
                        @switch($pesan->status)
                            @case('unread')
                                <span class="badge-himapro badge-yellow">Belum Dibaca</span>
                                @break
                            @case('read')
                                <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">Dibaca</span>
                                @break
                            @case('replied')
                                <span class="badge-himapro badge-active">Dibalas</span>
                                @break
                            @case('archived')
                                <span class="badge-himapro" style="background: rgba(255,255,255,.05); color: var(--muted); border-color: var(--border);">Diarsipkan</span>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Dikirim</div>
                    <div class="info-block-value">
                        {{ $pesan->created_at?->format('d F Y, H:i') }}
                    </div>
                </div>

                @if ($pesan->dibaca_at)
                    <div class="info-block">
                        <div class="info-block-label">Dibaca</div>
                        <div class="info-block-value">
                            {{ $pesan->dibaca_at->format('d F Y, H:i') }}
                        </div>
                    </div>
                @endif

                @if ($pesan->dibalas_at)
                    <div class="info-block" style="margin-bottom: 0;">
                        <div class="info-block-label">Dibalas</div>
                        <div class="info-block-value">
                            {{ $pesan->dibalas_at->format('d F Y, H:i') }}
                        </div>
                    </div>
                @endif

            </div>
        </div>


        {{-- HAPUS --}}
        <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card-header">
                <h2 class="admin-card-title" style="color: #fca5a5;">Zona Berbahaya</h2>
                <p class="card-subtitle">Tindakan yang tidak dapat dibatalkan</p>
            </div>
            <div class="card-body">

                <p style="font-size: 12.5px; color: var(--muted); margin-bottom: 14px;">
                    Menghapus pesan akan menghilangkan data ini secara permanen.
                </p>

                <form action="{{ route('admin.pesan.destroy', $pesan) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-himapro btn-himapro-danger" style="width: 100%; justify-content: center;">
                        <i class="bi bi-trash"></i>
                        Hapus Pesan
                    </button>
                </form>

            </div>
        </div>

    </div>

</div>


{{-- TOMBOL BAWAH --}}
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.pesan.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

@endsection
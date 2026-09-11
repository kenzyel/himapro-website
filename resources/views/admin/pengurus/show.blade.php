@extends('layouts.admin')

@section('title', $pengurus->nama)

@section('content')

<a href="{{ route('admin.pengurus.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Pengurus
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $pengurus->nama }}</h1>
        <p>{{ $pengurus->jabatan }} — Periode {{ $pengurus->periode }}</p>
    </div>

    @if (auth()->user()->hasPermission('pengurus.update'))
        <a href="{{ route('admin.pengurus.edit', $pengurus) }}" class="btn-himapro btn-himapro-primary">
            <i class="bi bi-pencil"></i>
            Edit Pengurus
        </a>
    @endif
</div>


<div class="admin-card" data-aos="fade-up">
    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-3 text-center">
                @if ($pengurus->foto)
                    <img src="{{ asset('storage/' . $pengurus->foto) }}"
                         alt="{{ $pengurus->nama }}"
                         class="avatar-photo-lg">
                @else
                    <div class="avatar-initials-lg">
                        {{ strtoupper(substr($pengurus->nama, 0, 1)) }}
                    </div>
                @endif

                <div class="mt-3">
                    @if ($pengurus->status === 'active')
                        <span class="badge-himapro badge-active">Aktif</span>
                    @else
                        <span class="badge-himapro badge-inactive">Non-Aktif</span>
                    @endif
                </div>
            </div>


            <div class="col-md-9">

                <div class="row g-3">

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Jabatan</div>
                        <div class="info-block-value">{{ $pengurus->jabatan }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Tipe Jabatan</div>
                        <div class="info-block-value">{{ ucfirst($pengurus->tipe_jabatan) }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Departemen</div>
                        <div class="info-block-value">{{ $pengurus->departemen?->nama ?? 'Pimpinan' }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Parent / Atasan</div>
                        <div class="info-block-value">{{ $pengurus->parent?->nama ?? '—' }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Email</div>
                        <div class="info-block-value {{ $pengurus->email ? '' : 'muted' }}">
                            {{ $pengurus->email ?? 'Belum ada email' }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Telepon</div>
                        <div class="info-block-value {{ $pengurus->telepon ? '' : 'muted' }}">
                            {{ $pengurus->telepon ?? 'Belum ada telepon' }}
                        </div>
                    </div>

                </div>


                @if ($pengurus->bio)
                    <div style="margin-top: 26px; padding-top: 24px; border-top: 1px solid var(--border);">
                        <div class="info-block-label">Bio</div>
                        <div class="info-block-value" style="font-weight: 500; line-height: 1.8;">
                            {!! nl2br(e($pengurus->bio)) !!}
                        </div>
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.pengurus.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if (auth()->user()->hasPermission('pengurus.delete'))
        <form action="{{ route('admin.pengurus.destroy', $pengurus) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus pengurus ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-himapro btn-himapro-danger">
                <i class="bi bi-trash"></i>
                Hapus
            </button>
        </form>
    @endif
</div>

@endsection
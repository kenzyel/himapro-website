@extends('layouts.admin')

@section('title', $partner->nama)

@section('content')

<a href="{{ route('admin.partner.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Partner
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $partner->nama }}</h1>
        <p>{{ $partner->deskripsi ? \Illuminate\Support\Str::limit($partner->deskripsi, 100) : 'Detail partner HIMAPRO TI SAKTI.' }}</p>
    </div>

    @if (auth()->user()->hasPermission('partner.update'))
        <a href="{{ route('admin.partner.edit', $partner) }}" class="btn-himapro btn-himapro-primary">
            <i class="bi bi-pencil"></i>
            Edit Partner
        </a>
    @endif
</div>


<div class="row g-4">

    <div class="col-lg-4">
        <div class="admin-card" data-aos="fade-up">
            <div class="card-body text-center" style="padding: 32px 24px;">

                @if ($partner->logo)
                    <div style="
                        padding: 24px;
                        background: rgba(255,255,255,.03);
                        border: 1px solid var(--border);
                        border-radius: var(--radius-lg);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        min-height: 200px;
                    ">
                        <img src="{{ asset('storage/' . $partner->logo) }}"
                             alt="{{ $partner->nama }}"
                             style="max-width: 100%; max-height: 180px; object-fit: contain;">
                    </div>
                @else
                    <div style="
                        width: 120px;
                        height: 120px;
                        margin: 0 auto;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: var(--radius-lg);
                        background: linear-gradient(135deg, var(--primary), var(--secondary));
                        color: #111;
                        font-size: 48px;
                        box-shadow: 0 8px 24px rgba(255,210,26,.3);
                    ">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                @endif

                <div style="margin-top: 20px;">
                    @if ($partner->status === 'active')
                        <span class="badge-himapro badge-active">Aktif</span>
                    @else
                        <span class="badge-himapro badge-inactive">Non-Aktif</span>
                    @endif
                </div>

            </div>
        </div>
    </div>


    <div class="col-lg-8">
        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">

            <div class="card-header">
                <h2 class="admin-card-title">Informasi Partner</h2>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Nama</div>
                        <div class="info-block-value">{{ $partner->nama }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Urutan</div>
                        <div class="info-block-value">#{{ $partner->urutan }}</div>
                    </div>

                    <div class="col-12 info-block">
                        <div class="info-block-label">Slug</div>
                        <div class="info-block-value" style="font-weight: 500; color: var(--muted);">
                            <code>{{ $partner->slug }}</code>
                        </div>
                    </div>

                    <div class="col-12 info-block">
                        <div class="info-block-label">Website</div>
                        <div class="info-block-value">
                            @if ($partner->website)
                                <a href="{{ $partner->website }}"
                                   target="_blank"
                                   style="color: var(--primary); text-decoration: none;">
                                    <i class="bi bi-link-45deg"></i>
                                    {{ $partner->website }}
                                </a>
                            @else
                                <span style="color: var(--muted); font-weight: 500; font-style: italic;">
                                    Belum ada website
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 info-block" style="margin-bottom: 0;">
                        <div class="info-block-label">Deskripsi</div>
                        <div class="info-block-value" style="font-weight: 500; line-height: 1.8;">
                            {!! nl2br(e($partner->deskripsi ?: 'Belum ada deskripsi.')) !!}
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.partner.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if (auth()->user()->hasPermission('partner.delete'))
        <form action="{{ route('admin.partner.destroy', $partner) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus partner ini?')">
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
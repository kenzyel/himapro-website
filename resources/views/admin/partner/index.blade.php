@extends('layouts.admin')

@section('title', 'Partner')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Partner</h1>
    <p>Kelola mitra dan sponsor HIMAPRO TI SAKTI.</p>
</div>


@if (session('success'))
    <div class="alert alert-success alert-dismissible" data-aos="fade-down">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible" data-aos="fade-down">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif


<div class="admin-card" data-aos="fade-up">

    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="admin-card-title">Daftar Partner</h2>
                <p class="card-subtitle">Total {{ $partners->total() }} partner terdaftar</p>
            </div>

            @if (auth()->user()->hasPermission('partner.create'))
                <a href="{{ route('admin.partner.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Partner
                </a>
            @endif
        </div>
    </div>


    {{-- FILTER --}}
    <div class="px-4 pt-4">
        <form method="GET" class="filter-card">
            <div class="row g-2">

                <div class="col-lg-7 col-md-7">
                    <label class="form-label">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Cari nama partner..."
                    >
                </div>

                <div class="col-lg-3 col-md-5">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active" @selected(request('status') === 'active')>Aktif</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Non-Aktif</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.partner.index') }}" class="btn-icon" title="Reset">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>

            </div>
        </form>
    </div>


    {{-- TABLE --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="px-4" width="60">#</th>
                        <th>Partner</th>
                        <th>Website</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($partners as $index => $partner)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $partners->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($partner->logo)
                                        <div style="
                                            width: 48px;
                                            height: 48px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            background: rgba(255,255,255,.05);
                                            border: 1px solid var(--border);
                                            border-radius: 10px;
                                            overflow: hidden;
                                        ">
                                            <img src="{{ asset('storage/' . $partner->logo) }}"
                                                 alt="{{ $partner->nama }}"
                                                 style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        </div>
                                    @else
                                        <div style="
                                            width: 48px;
                                            height: 48px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            border-radius: 10px;
                                            background: rgba(255,210,26,.1);
                                            border: 1px solid rgba(255,210,26,.2);
                                            color: var(--primary);
                                            font-size: 20px;
                                        ">
                                            <i class="bi bi-briefcase-fill"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <div style="font-weight: 700; font-size: 13px;">
                                            {{ $partner->nama }}
                                        </div>
                                        <div style="font-size: 11px; color: var(--muted);">
                                            {{ $partner->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td style="font-size: 12px;">
                                @if ($partner->website)
                                    <a href="{{ $partner->website }}"
                                       target="_blank"
                                       style="color: var(--primary); text-decoration: none;">
                                        <i class="bi bi-link-45deg"></i>
                                        {{ \Illuminate\Support\Str::limit(parse_url($partner->website, PHP_URL_HOST) ?: $partner->website, 30) }}
                                    </a>
                                @else
                                    <span style="color: var(--muted);">—</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge-himapro badge-yellow">
                                    #{{ $partner->urutan }}
                                </span>
                            </td>

                            <td>
                                @if ($partner->status === 'active')
                                    <span class="badge-himapro badge-active">Aktif</span>
                                @else
                                    <span class="badge-himapro badge-inactive">Non-Aktif</span>
                                @endif
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.partner.show', $partner) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('partner.update'))
                                        <a href="{{ route('admin.partner.edit', $partner) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('partner.delete'))
                                        <form action="{{ route('admin.partner.destroy', $partner) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus partner ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada partner</h6>
                                <p class="mb-3">Tambahkan partner pertama HIMAPRO TI SAKTI.</p>

                                @if (auth()->user()->hasPermission('partner.create'))
                                    <a href="{{ route('admin.partner.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Partner
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($partners->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $partners->links() }}
        </div>
    @endif

</div>

@endsection
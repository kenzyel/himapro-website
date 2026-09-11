@extends('layouts.admin')

@section('title', 'Landing Page')

@section('content')

@php
    $canUpdate = auth()->user()->hasPermission('settings.update');
    $totalSection = $sections->count();
    $totalActive = $sections->where('is_active', true)->count();
    $totalInactive = $totalSection - $totalActive;
@endphp

{{-- HEADER --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>Landing Page</h1>
        <p>Kelola konten halaman utama website tanpa mengubah kode.</p>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('home') }}" target="_blank" class="btn-himapro btn-himapro-secondary">
            <i class="bi bi-eye"></i>
            Preview Website
        </a>
    </div>
</div>


{{-- ALERT --}}
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

@if (! $canUpdate)
    <div class="alert alert-warning" data-aos="fade-down" style="margin-bottom: 22px;">
        <i class="bi bi-info-circle-fill"></i>
        <div>
            Anda hanya dapat <strong>melihat</strong> konten. Hubungi administrator untuk mengubah.
        </div>
    </div>
@endif


{{-- STATISTIK MINI --}}
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-lg-4 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Section</span>
                <span class="stat-icon"><i class="bi bi-layout-text-window-reverse"></i></span>
            </div>
            <div class="stat-value">{{ $totalSection }}</div>
            <div class="stat-description">Section terdaftar</div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Section Aktif</span>
                <span class="stat-icon" style="background: rgba(34,197,94,.1); color: #86efac; border-color: rgba(34,197,94,.2);">
                    <i class="bi bi-eye-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="color: #86efac;">{{ $totalActive }}</div>
            <div class="stat-description">Tampil di website</div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Non-Aktif</span>
                <span class="stat-icon" style="background: rgba(239,68,68,.1); color: #fca5a5; border-color: rgba(239,68,68,.2);">
                    <i class="bi bi-eye-slash-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="color: #fca5a5;">{{ $totalInactive }}</div>
            <div class="stat-description">Disembunyikan</div>
        </div>
    </div>
</div>


{{-- TIPS DRAG --}}
@if ($canUpdate)
    <div class="landing-tips" data-aos="fade-up">
        <div class="landing-tips-icon">
            <i class="bi bi-hand-index-thumb-fill"></i>
        </div>
        <div class="landing-tips-content">
            <div class="landing-tips-title">Kelola Urutan Section</div>
            <div class="landing-tips-text">
                Drag & drop icon <i class="bi bi-grip-vertical"></i> untuk mengubah urutan tampil section di landing page.
            </div>
        </div>
    </div>
@endif


{{-- GRID SECTION --}}
<div
    class="landing-sections-grid"
    id="sortableSections"
    data-reorder-url="{{ $canUpdate ? route('admin.landing-page.reorder') : '' }}"
    data-aos="fade-up"
>

    @foreach ($sections as $section)
        @php
            $content = $section->content ?? [];
            $icon = match ($section->key) {
                'hero' => 'bi-stars',
                'about' => 'bi-info-circle-fill',
                'program_kerja' => 'bi-kanban-fill',
                'agenda' => 'bi-calendar-event-fill',
                'pengumuman' => 'bi-megaphone-fill',
                'gallery' => 'bi-images',
                'partner' => 'bi-briefcase-fill',
                'cta' => 'bi-megaphone',
                default => 'bi-square',
            };
            $iconColor = match ($section->key) {
                'hero' => 'primary',
                'about' => 'blue',
                'program_kerja' => 'purple',
                'agenda' => 'orange',
                'pengumuman' => 'green',
                'gallery' => 'pink',
                'partner' => 'teal',
                'cta' => 'red',
                default => 'primary',
            };
        @endphp

        <div
            class="landing-section-card {{ $section->is_active ? '' : 'inactive' }}"
            data-id="{{ $section->id }}"
        >

            {{-- DRAG HANDLE --}}
            @if ($canUpdate)
                <div class="landing-section-drag" title="Drag untuk reorder">
                    <i class="bi bi-grip-vertical"></i>
                </div>
            @else
                <div class="landing-section-order">
                    {{ $loop->iteration }}
                </div>
            @endif


            {{-- ICON --}}
            <div class="landing-section-icon icon-{{ $iconColor }}">
                <i class="bi {{ $icon }}"></i>
            </div>


            {{-- INFO --}}
            <div class="landing-section-info">

                <div class="landing-section-header">
                    <div class="landing-section-name">
                        {{ $section->name }}
                    </div>

                    @if ($section->is_active)
                        <span class="landing-status-dot landing-status-active" title="Aktif"></span>
                    @else
                        <span class="landing-status-dot landing-status-inactive" title="Non-Aktif"></span>
                    @endif
                </div>

                <div class="landing-section-subtitle">
                    @if (! empty($content['title']))
                        {!! strip_tags($content['title']) !!}
                    @elseif (! empty($section->title))
                        {{ $section->title }}
                    @else
                        <span class="text-muted">Belum ada konten</span>
                    @endif
                </div>

                <div class="landing-section-meta">
                    @if (! empty($content['label']))
                        <span class="landing-meta-pill">
                            <i class="bi bi-tag-fill"></i>
                            {{ $content['label'] }}
                        </span>
                    @endif

                    @if (isset($content['limit']))
                        <span class="landing-meta-pill">
                            <i class="bi bi-list-ol"></i>
                            Tampil {{ $content['limit'] }}
                        </span>
                    @endif

                    <span class="landing-meta-pill muted">
                        <code>{{ $section->key }}</code>
                    </span>
                </div>

            </div>


            {{-- AKSI --}}
            <div class="landing-section-actions">

                @if ($canUpdate)

                    {{-- Toggle Aktif/Non-Aktif --}}
                    <form action="{{ route('admin.landing-page.toggle', $section) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button
                            type="submit"
                            class="landing-action-btn {{ $section->is_active ? 'active' : '' }}"
                            title="{{ $section->is_active ? 'Sembunyikan dari website' : 'Tampilkan di website' }}"
                        >
                            <i class="bi bi-{{ $section->is_active ? 'eye-fill' : 'eye-slash' }}"></i>
                        </button>
                    </form>

                    {{-- Edit --}}
                    <a
                        href="{{ route('admin.landing-page.edit', $section) }}"
                        class="landing-action-btn primary"
                        title="Edit Konten"
                    >
                        <i class="bi bi-pencil-fill"></i>
                    </a>

                    {{-- Reset --}}
                    <form action="{{ route('admin.landing-page.reset', $section) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Reset section ini ke pengaturan default?\n\nSemua perubahan pada section ini akan hilang.')">
                        @csrf
                        @method('PATCH')
                        <button
                            type="submit"
                            class="landing-action-btn danger"
                            title="Reset ke Default"
                        >
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                    </form>

                @else

                    <a
                        href="{{ route('admin.landing-page.edit', $section) }}"
                        class="landing-action-btn"
                        title="Lihat"
                    >
                        <i class="bi bi-eye-fill"></i>
                    </a>

                @endif

            </div>

        </div>
    @endforeach

</div>


@if ($sections->count() === 0)
    <div class="admin-card" data-aos="fade-up">
        <div class="card-body">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-layout-text-window-reverse"></i>
                </div>
                <h6 class="fw-bold mb-2">Belum ada section</h6>
                <p class="mb-0">
                    Jalankan seeder: <code>php artisan db:seed --class=LandingSectionSeeder</code>
                </p>
            </div>
        </div>
    </div>
@endif

@endsection


@push('styles')
<style>
/* =========================================================
   TIPS BOX
   ========================================================= */

.landing-tips {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    border-radius: var(--radius);
    background: linear-gradient(135deg, rgba(255, 210, 26, 0.06), rgba(245, 169, 0, 0.02));
    border: 1px solid rgba(255, 210, 26, 0.2);
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
}

.landing-tips::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: var(--primary);
    box-shadow: 0 0 12px var(--primary);
}

.landing-tips-icon {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: rgba(255, 210, 26, 0.15);
    border: 1px solid rgba(255, 210, 26, 0.3);
    color: var(--primary);
    font-size: 20px;
    flex-shrink: 0;
}

.landing-tips-title {
    font-size: 13.5px;
    font-weight: 800;
    margin-bottom: 3px;
}

.landing-tips-text {
    font-size: 12.5px;
    color: var(--muted);
    line-height: 1.5;
}

/* =========================================================
   GRID
   ========================================================= */

.landing-sections-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

@media (max-width: 991.98px) {
    .landing-sections-grid {
        grid-template-columns: 1fr;
    }
}

/* =========================================================
   CARD
   ========================================================= */

.landing-section-card {
    display: grid;
    grid-template-columns: 32px 60px 1fr auto;
    gap: 16px;
    align-items: center;
    padding: 20px 22px;
    border-radius: var(--radius-lg);
    background: linear-gradient(145deg, #1d1d20 0%, #18181b 100%);
    border: 1px solid var(--border);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.landing-section-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 20%;
    right: 20%;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--primary), transparent);
    opacity: 0;
    transition: opacity 0.25s ease;
}

.landing-section-card:hover {
    border-color: rgba(255, 210, 26, 0.35);
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5);
}

.landing-section-card:hover::before {
    opacity: 1;
}

.landing-section-card.inactive {
    opacity: 0.6;
}

.landing-section-card.inactive:hover {
    opacity: 0.85;
}

/* DRAG HANDLE */

.landing-section-drag {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 60px;
    border-radius: 8px;
    background: rgba(255, 210, 26, 0.05);
    border: 1px solid rgba(255, 210, 26, 0.15);
    color: var(--primary);
    font-size: 16px;
    cursor: grab;
    transition: all 0.2s ease;
    opacity: 0.6;
}

.landing-section-card:hover .landing-section-drag {
    opacity: 1;
    background: rgba(255, 210, 26, 0.12);
}

.landing-section-drag:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 16px rgba(255, 210, 26, 0.3);
}

.landing-section-drag:active {
    cursor: grabbing;
}

.landing-section-order {
    font-size: 14px;
    font-weight: 900;
    color: var(--muted);
    text-align: center;
    width: 32px;
}

/* SORTABLE STATES */

.landing-section-card.sortable-ghost {
    opacity: 0.3;
    background: rgba(255, 210, 26, 0.1);
    border-style: dashed;
    border-color: var(--primary);
}

.landing-section-card.sortable-drag {
    background: var(--card);
    box-shadow: 0 24px 60px rgba(255, 210, 26, 0.4);
    border-color: var(--primary);
    transform: rotate(2deg) scale(1.02);
    cursor: grabbing;
}

/* ICON */

.landing-section-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    font-size: 26px;
    transition: all 0.25s ease;
    border: 1px solid;
}

.landing-section-card:hover .landing-section-icon {
    transform: scale(1.05) rotate(-3deg);
}

.landing-section-icon.icon-primary {
    background: linear-gradient(135deg, rgba(255, 210, 26, 0.15), rgba(245, 169, 0, 0.05));
    border-color: rgba(255, 210, 26, 0.3);
    color: #FFD21A;
}

.landing-section-icon.icon-blue {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.05));
    border-color: rgba(59, 130, 246, 0.3);
    color: #93c5fd;
}

.landing-section-icon.icon-purple {
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.15), rgba(168, 85, 247, 0.05));
    border-color: rgba(168, 85, 247, 0.3);
    color: #c4b5fd;
}

.landing-section-icon.icon-orange {
    background: linear-gradient(135deg, rgba(251, 146, 60, 0.15), rgba(251, 146, 60, 0.05));
    border-color: rgba(251, 146, 60, 0.3);
    color: #fdba74;
}

.landing-section-icon.icon-green {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.05));
    border-color: rgba(34, 197, 94, 0.3);
    color: #86efac;
}

.landing-section-icon.icon-pink {
    background: linear-gradient(135deg, rgba(236, 72, 153, 0.15), rgba(236, 72, 153, 0.05));
    border-color: rgba(236, 72, 153, 0.3);
    color: #f9a8d4;
}

.landing-section-icon.icon-teal {
    background: linear-gradient(135deg, rgba(20, 184, 166, 0.15), rgba(20, 184, 166, 0.05));
    border-color: rgba(20, 184, 166, 0.3);
    color: #5eead4;
}

.landing-section-icon.icon-red {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(239, 68, 68, 0.05));
    border-color: rgba(239, 68, 68, 0.3);
    color: #fca5a5;
}

/* INFO */

.landing-section-info {
    min-width: 0;
    flex: 1;
}

.landing-section-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 6px;
}

.landing-section-name {
    font-size: 15px;
    font-weight: 800;
    letter-spacing: -0.01em;
}

.landing-status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
    animation: statusPulse 2s ease-in-out infinite;
}

.landing-status-active {
    background: #86efac;
    box-shadow: 0 0 8px rgba(134, 239, 172, 0.8);
}

.landing-status-inactive {
    background: #fca5a5;
    box-shadow: 0 0 8px rgba(252, 165, 165, 0.8);
}

@keyframes statusPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.landing-section-subtitle {
    font-size: 12.5px;
    color: var(--text);
    line-height: 1.5;
    margin-bottom: 10px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
}

.landing-section-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.landing-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 999px;
    background: rgba(255, 210, 26, 0.08);
    border: 1px solid rgba(255, 210, 26, 0.15);
    color: var(--primary);
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.02em;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.landing-meta-pill.muted {
    background: rgba(255, 255, 255, 0.03);
    border-color: var(--border);
    color: var(--muted);
}

.landing-meta-pill i {
    font-size: 10px;
}

.landing-meta-pill code {
    color: var(--muted);
    font-size: 10.5px;
}

/* AKSI */

.landing-section-actions {
    display: flex;
    gap: 6px;
    flex-shrink: 0;
}

.landing-action-btn {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid var(--border);
    color: var(--text);
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
    text-decoration: none;
}

.landing-action-btn:hover {
    background: rgba(255, 210, 26, 0.1);
    border-color: rgba(255, 210, 26, 0.35);
    color: var(--primary);
    transform: translateY(-2px);
}

.landing-action-btn.active {
    background: rgba(34, 197, 94, 0.1);
    border-color: rgba(34, 197, 94, 0.3);
    color: #86efac;
}

.landing-action-btn.active:hover {
    background: rgba(34, 197, 94, 0.2);
    border-color: rgba(34, 197, 94, 0.5);
    color: #86efac;
}

.landing-action-btn.primary {
    background: rgba(255, 210, 26, 0.12);
    border-color: rgba(255, 210, 26, 0.3);
    color: var(--primary);
}

.landing-action-btn.primary:hover {
    background: var(--primary);
    color: #111;
    border-color: var(--primary);
    box-shadow: 0 6px 24px rgba(255, 210, 26, 0.4);
}

.landing-action-btn.danger:hover {
    background: rgba(239, 68, 68, 0.12);
    border-color: rgba(239, 68, 68, 0.35);
    color: #fca5a5;
}

/* RESPONSIVE */

@media (max-width: 767.98px) {
    .landing-section-card {
        grid-template-columns: 32px 1fr;
        grid-template-areas:
            "drag icon"
            "info info"
            "action action";
        gap: 14px;
        text-align: center;
        padding: 22px 18px;
    }

    .landing-section-drag,
    .landing-section-order {
        grid-area: drag;
        align-self: start;
    }

    .landing-section-icon {
        grid-area: icon;
        margin: 0 auto;
    }

    .landing-section-info {
        grid-area: info;
        text-align: center;
    }

    .landing-section-header {
        justify-content: center;
    }

    .landing-section-meta {
        justify-content: center;
    }

    .landing-section-actions {
        grid-area: action;
        justify-content: center;
    }
}
</style>
@endpush


@push('scripts')
@if ($canUpdate)
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const container = document.getElementById('sortableSections');

        if (!container) return;

        const reorderUrl = container.dataset.reorderUrl;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        if (!reorderUrl || !csrfToken) return;

        Sortable.create(container, {
            animation: 200,
            handle: '.landing-section-drag',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function () {
                const order = Array.from(
                    container.querySelectorAll('.landing-section-card')
                ).map(el => parseInt(el.dataset.id));

                fetch(reorderUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ order: order }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast('✓ Urutan berhasil disimpan', 'success');
                    } else {
                        showToast('✗ Gagal menyimpan urutan', 'error');
                    }
                })
                .catch(() => {
                    showToast('✗ Terjadi kesalahan', 'error');
                });
            }
        });

        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = 'landing-toast landing-toast-' + type;
            toast.textContent = message;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 400);
            }, 2500);
        }

    });
    </script>
@endif
@endpush
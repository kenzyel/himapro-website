@extends('layouts.admin')

@section('title', $user->name)

@section('content')

<a href="{{ route('admin.users.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke User
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $user->name }}</h1>
        <p>Detail akun pengguna sistem.</p>
    </div>

    <a href="{{ route('admin.users.edit', $user) }}" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-pencil"></i>
        Edit User
    </a>
</div>


<div class="row g-4">

    {{-- PROFIL --}}
    <div class="col-lg-4">
        <div class="admin-card" data-aos="fade-up">
            <div class="card-body text-center" style="padding: 32px 24px;">

                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}"
                         alt="{{ $user->name }}"
                         style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 2px solid var(--primary); box-shadow: 0 8px 24px rgba(255,210,26,.25);">
                @else
                    <div style="
                        width: 120px;
                        height: 120px;
                        margin: 0 auto;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 50%;
                        background: linear-gradient(135deg, var(--primary), var(--secondary));
                        color: #111;
                        font-weight: 900;
                        font-size: 44px;
                        box-shadow: 0 8px 24px rgba(255,210,26,.3);
                    ">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <h2 style="font-size: 18px; font-weight: 800; margin-top: 20px; margin-bottom: 6px;">
                    {{ $user->name }}
                </h2>

                <p style="color: var(--muted); font-size: 13px; margin-bottom: 14px;">
                    {{ $user->email }}
                </p>

                @if ($user->status === 'active')
                    <span class="badge-himapro badge-active">Aktif</span>
                @else
                    <span class="badge-himapro badge-inactive">Non-Aktif</span>
                @endif

            </div>
        </div>
    </div>


    {{-- DETAIL --}}
    <div class="col-lg-8">

        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header">
                <h2 class="admin-card-title">Informasi Akun</h2>
            </div>
            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Nama</div>
                        <div class="info-block-value">{{ $user->name }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Email</div>
                        <div class="info-block-value">{{ $user->email }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Role</div>
                        <div class="info-block-value">
                            <span class="badge-himapro badge-yellow">
                                {{ $user->role?->name ?? 'Tanpa Role' }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Status</div>
                        <div>
                            @if ($user->status === 'active')
                                <span class="badge-himapro badge-active">Aktif</span>
                            @else
                                <span class="badge-himapro badge-inactive">Non-Aktif</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Dibuat</div>
                        <div class="info-block-value">
                            {{ $user->created_at?->format('d F Y, H:i') }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block" style="margin-bottom: 0;">
                        <div class="info-block-label">Terakhir Update</div>
                        <div class="info-block-value">
                            {{ $user->updated_at?->format('d F Y, H:i') }}
                        </div>
                    </div>

                </div>

            </div>
        </div>


        {{-- PERMISSIONS --}}
        @if ($user->role && $user->role->permissions->count() > 0)
            <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="150">
                <div class="card-header">
                    <h2 class="admin-card-title">Permission Role</h2>
                    <p class="card-subtitle">Permission yang dimiliki role {{ $user->role->name }}</p>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($user->role->permissions as $permission)
                            <span class="badge-himapro badge-yellow" style="text-transform: none;">
                                {{ $permission->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </div>

</div>


{{-- TOMBOL --}}
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.users.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if ($user->id !== auth()->id())
        <form action="{{ route('admin.users.destroy', $user) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
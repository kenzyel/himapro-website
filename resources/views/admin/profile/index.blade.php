@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Profil Saya</h1>
    <p>Kelola informasi akun dan keamanan Anda.</p>
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


<div class="row g-4">

    {{-- KARTU PROFIL --}}
    <div class="col-lg-4">

        <div class="admin-card" data-aos="fade-up">
            <div class="card-body text-center" style="padding: 32px 24px;">

                {{-- AVATAR --}}
                @if ($user->avatar)
                    <img
                        src="{{ asset('storage/' . $user->avatar) }}"
                        alt="{{ $user->name }}"
                        style="
                            width: 130px;
                            height: 130px;
                            margin: 0 auto;
                            object-fit: cover;
                            border-radius: 50%;
                            border: 4px solid rgba(255, 210, 26, 0.3);
                            box-shadow: 0 8px 32px rgba(255, 210, 26, 0.25);
                        "
                    >
                @else
                    <div style="
                        width: 130px;
                        height: 130px;
                        margin: 0 auto;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 50%;
                        background: linear-gradient(135deg, var(--primary), var(--secondary));
                        color: #111;
                        font-weight: 900;
                        font-size: 52px;
                        box-shadow: 0 8px 32px rgba(255, 210, 26, 0.3);
                    ">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <h2 style="font-size: 20px; font-weight: 800; margin-top: 20px; margin-bottom: 6px;">
                    {{ $user->name }}
                </h2>

                <p style="color: var(--muted); font-size: 13px; margin-bottom: 14px;">
                    {{ $user->email }}
                </p>

                <span class="badge-himapro badge-yellow" style="text-transform: none;">
                    <i class="bi bi-shield-fill-check"></i>
                    {{ $user->role?->name ?? 'Tanpa Role' }}
                </span>

                <div style="
                    margin-top: 24px;
                    padding-top: 20px;
                    border-top: 1px solid var(--border);
                    font-size: 11.5px;
                    color: var(--muted);
                ">
                    <div>
                        <i class="bi bi-calendar3"></i>
                        Bergabung {{ $user->created_at?->format('d M Y') }}
                    </div>
                    <div style="margin-top: 6px;">
                        <i class="bi bi-clock"></i>
                        Update terakhir {{ $user->updated_at?->format('d M Y H:i') }}
                    </div>
                </div>

            </div>
        </div>

    </div>


    {{-- FORM --}}
    <div class="col-lg-8">

        {{-- FORM PROFIL --}}
        <div class="admin-card" data-aos="fade-up" data-aos-delay="50">

            <div class="card-header">
                <div>
                    <h2 class="admin-card-title">Informasi Profil</h2>
                    <p class="card-subtitle">Perbarui nama, email, dan avatar</p>
                </div>
            </div>

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

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label for="name" class="form-label">
                                Nama Lengkap <span style="color: var(--primary);">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">
                                Email <span style="color: var(--primary);">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input
                                type="file"
                                id="avatar"
                                name="avatar"
                                class="form-control @error('avatar') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.webp"
                            >
                            <div class="form-text">Format JPG, PNG, WEBP. Maksimal 2 MB.</div>
                            @error('avatar')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div id="avatar-preview-container" class="d-none">
                                <label class="form-label">Preview Avatar Baru</label>
                                <div>
                                    <img
                                        id="avatar-preview"
                                        src=""
                                        alt="Preview"
                                        style="
                                            width: 80px;
                                            height: 80px;
                                            border-radius: 50%;
                                            object-fit: cover;
                                            border: 2px solid var(--primary);
                                            box-shadow: 0 4px 16px rgba(255, 210, 26, 0.3);
                                        "
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2 pt-3" style="border-top: 1px solid var(--border);">
                                <button type="reset" class="btn-himapro btn-himapro-secondary">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                    Reset
                                </button>

                                <button type="submit" class="btn-himapro btn-himapro-primary">
                                    <i class="bi bi-check-lg"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

            </div>

        </div>


        {{-- FORM PASSWORD --}}
        <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="100">

            <div class="card-header">
                <div>
                    <h2 class="admin-card-title">Ganti Password</h2>
                    <p class="card-subtitle">Perbarui password akun Anda</p>
                </div>
            </div>

            <div class="card-body">

                @if ($errors->has('current_password') || $errors->has('password'))
                    <div class="alert alert-danger mb-4">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach ($errors->only(['current_password', 'password']) as $field => $messages)
                                    @foreach ($messages as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-12">
                            <label for="current_password" class="form-label">
                                Password Saat Ini <span style="color: var(--primary);">*</span>
                            </label>
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                autocomplete="current-password"
                                required
                            >
                            @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">
                                Password Baru <span style="color: var(--primary);">*</span>
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="new-password"
                                required
                            >
                            <div class="form-text">Minimal 8 karakter.</div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">
                                Konfirmasi Password Baru <span style="color: var(--primary);">*</span>
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <div class="col-12">
                            <div class="d-flex justify-content-end pt-3" style="border-top: 1px solid var(--border);">
                                <button type="submit" class="btn-himapro btn-himapro-primary">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    Update Password
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('avatar');
    const container = document.getElementById('avatar-preview-container');
    const img = document.getElementById('avatar-preview');

    if (!input || !container || !img) return;

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (!file || !file.type.startsWith('image/')) {
            container.classList.add('d-none');
            img.src = '';
            return;
        }

        const url = URL.createObjectURL(file);
        img.src = url;
        container.classList.remove('d-none');

        img.onload = () => URL.revokeObjectURL(url);
    });
});
</script>
@endpush
@extends('layouts.admin')

@section('title', 'Edit Foto')

@section('content')

<div class="d-flex align-items-center gap-2 mb-2" data-aos="fade-down" style="font-size: 12px;">
    <a href="{{ route('admin.gallery.index') }}" class="page-header-breadcrumb" style="margin-bottom: 0;">
        <i class="bi bi-arrow-left"></i>
        Gallery
    </a>
    <span style="color: var(--muted);">/</span>
    <a href="{{ route('admin.gallery.show', $gallery) }}" class="page-header-breadcrumb" style="margin-bottom: 0;">
        {{ $gallery->nama }}
    </a>
    <span style="color: var(--muted);">/</span>
    <span style="color: var(--text); font-weight: 700;">Edit Foto</span>
</div>

<div class="page-header" data-aos="fade-down">
    <h1>Edit Foto</h1>
    <p>Perbarui informasi foto dalam gallery <strong>{{ $gallery->nama }}</strong>.</p>
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

        <form action="{{ route('admin.gallery.items.update', [$gallery, $galleryItem]) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- SECTION: FOTO SAAT INI --}}
                <div class="col-12">
                    <div class="form-section-title">Foto</div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Foto Saat Ini</label>
                    <div class="photo-preview">
                        @if ($galleryItem->file)
                            <img src="{{ asset('storage/' . $galleryItem->file) }}"
                                 alt="{{ $galleryItem->judul ?: 'Foto gallery' }}"
                                 style="width: 100%; max-width: 100%; height: auto; max-height: 260px; object-fit: cover;">
                        @else
                            <div style="padding: 30px; color: var(--muted);">
                                <i class="bi bi-image" style="font-size: 36px; display: block; margin-bottom: 8px;"></i>
                                Foto tidak tersedia
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-8">
                    <label for="file" class="form-label">Ganti Foto (opsional)</label>
                    <input
                        type="file"
                        id="file"
                        name="file"
                        class="form-control @error('file') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp,image/*"
                    >
                    <div class="form-text">
                        Kosongkan jika tidak ingin mengganti foto. Format JPG, JPEG, PNG, WEBP. Maks 5 MB.
                    </div>
                    @error('file')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    <div id="image-preview-container" class="d-none mt-3">
                        <label class="form-label">Preview Foto Baru</label>
                        <div class="photo-preview">
                            <img id="image-preview" src="" alt="Preview" style="width: 100%; max-width: 100%; height: auto; max-height: 220px; object-fit: contain;">
                        </div>
                    </div>
                </div>

                {{-- SECTION: DETAIL --}}
                <div class="col-12">
                    <div class="form-section-title">Detail Foto</div>
                </div>

                <div class="col-12">
                    <label for="judul" class="form-label">Judul Foto</label>
                    <input
                        type="text"
                        id="judul"
                        name="judul"
                        class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul', $galleryItem->judul) }}"
                        maxlength="255"
                        placeholder="Contoh: Pembukaan Rapat Kerja"
                    >
                    @error('judul')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="caption" class="form-label">Caption</label>
                    <textarea
                        id="caption"
                        name="caption"
                        rows="5"
                        class="form-control @error('caption') is-invalid @enderror"
                        placeholder="Tuliskan caption atau keterangan foto..."
                    >{{ old('caption', $galleryItem->caption) }}</textarea>
                    @error('caption')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- SECTION: PENGATURAN --}}
                <div class="col-12">
                    <div class="form-section-title">Pengaturan</div>
                </div>

                <div class="col-md-4">
                    <label for="urutan" class="form-label">Urutan</label>
                    <input
                        type="number"
                        id="urutan"
                        name="urutan"
                        class="form-control @error('urutan') is-invalid @enderror"
                        value="{{ old('urutan', $galleryItem->urutan) }}"
                        min="0"
                    >
                    <div class="form-text">Menentukan posisi foto dalam gallery.</div>
                    @error('urutan')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>


            {{-- ACTION BUTTONS --}}
            <div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
                <a href="{{ route('admin.gallery.show', $gallery) }}" class="btn-himapro btn-himapro-secondary">
                    <i class="bi bi-x-lg"></i>
                    Batal
                </a>

                <button type="submit" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-check-lg"></i>
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('file');
    const container = document.getElementById('image-preview-container');
    const img = document.getElementById('image-preview');

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
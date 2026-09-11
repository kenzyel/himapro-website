@extends('layouts.admin')

@section('title', 'Tambah Foto')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <div class="d-flex align-items-center gap-2 mb-2">

                <a
                    href="{{ route('admin.gallery.index') }}"
                    class="text-secondary text-decoration-none"
                >
                    Gallery
                </a>

                <span class="text-secondary">/</span>

                <a
                    href="{{ route('admin.gallery.show', $gallery) }}"
                    class="text-secondary text-decoration-none"
                >
                    {{ $gallery->nama }}
                </a>

                <span class="text-secondary">/</span>

                <span class="text-light">
                    Upload Foto
                </span>

            </div>

            <h1 class="h3 mb-1">
                Upload Banyak Foto
            </h1>

            <p class="text-secondary mb-0">
                Upload beberapa foto sekaligus ke gallery {{ $gallery->nama }}.
            </p>
        </div>

        <a
            href="{{ route('admin.gallery.show', $gallery) }}"
            class="btn-himapro btn-himapro-secondary"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke Gallery
        </a>

    </div>


    {{-- Error --}}
    @if($errors->any())

        <div class="alert alert-danger border-0 shadow-sm mb-4">

            <div class="fw-semibold mb-2">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Terjadi kesalahan:
            </div>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- Form --}}
    <form
        action="{{ route('admin.gallery.items.store', $gallery) }}"
        method="POST"
        enctype="multipart/form-data"
        id="uploadForm"
    >
        @csrf

        <div class="row g-4">

            {{-- LEFT: DROPZONE --}}
            <div class="col-lg-8">

                <div class="admin-card">
                    <div class="card-body">

                        <h5 class="mb-3">
                            <i class="bi bi-images me-2" style="color: var(--primary);"></i>
                            Pilih Foto
                        </h5>

                        <div id="dropzone" class="upload-dropzone">

                            <input
                                type="file"
                                name="files[]"
                                id="filesInput"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                multiple
                                hidden
                            >

                            <div class="upload-dropzone-inner">

                                <div class="upload-dropzone-icon">
                                    <i class="bi bi-cloud-arrow-up-fill"></i>
                                </div>

                                <h6 class="upload-dropzone-title">
                                    Drag & drop foto di sini
                                </h6>

                                <p class="upload-dropzone-subtitle">
                                    atau
                                </p>

                                <button
                                    type="button"
                                    class="btn-himapro btn-himapro-primary"
                                    onclick="document.getElementById('filesInput').click()"
                                >
                                    <i class="bi bi-folder2-open"></i>
                                    Pilih File
                                </button>

                                <p class="upload-dropzone-hint">
                                    Format: JPG, JPEG, PNG, WEBP. Maks 5 MB per file.
                                    <br>
                                    Bisa pilih <strong>maksimal 10 foto sekaligus</strong>.
                                </p>

                            </div>

                        </div>

                    </div>
                </div>

            </div>


            {{-- RIGHT: INFO + PREVIEW COUNTER --}}
            <div class="col-lg-4">

                <div class="admin-card mb-4">
                    <div class="card-body">

                        <h5 class="mb-3">
                            <i class="bi bi-info-circle me-2" style="color: var(--primary);"></i>
                            Informasi
                        </h5>

                        <div class="stat-mini" style="margin-bottom: 12px;">
                            <div class="stat-mini-label">
                                <i class="bi bi-images"></i>
                                Foto Dipilih
                            </div>
                            <div class="stat-mini-value" id="fileCount">0</div>
                        </div>

                        <div class="stat-mini" style="margin-bottom: 0;">
                            <div class="stat-mini-label">
                                <i class="bi bi-hdd-fill"></i>
                                Total Ukuran
                            </div>
                            <div class="stat-mini-value" style="font-size: 20px;" id="totalSize">0 B</div>
                        </div>

                    </div>
                </div>


                <div class="alert alert-warning" style="font-size: 12.5px;">
                    <i class="bi bi-lightbulb-fill me-2"></i>
                    <div>
                        <strong>Judul otomatis</strong> diambil dari nama file.
                        Caption bisa diisi nanti setelah upload.
                    </div>
                </div>

            </div>

        </div>


        {{-- PREVIEW GRID --}}
        <div id="previewContainer" class="d-none mt-4">
            <div class="admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-eye me-2" style="color: var(--primary);"></i>
                        Preview Foto
                    </h5>

                    <button
                        type="button"
                        class="btn-himapro btn-himapro-secondary"
                        onclick="clearAll()"
                        style="font-size: 11.5px; padding: 7px 12px;"
                    >
                        <i class="bi bi-x-lg"></i>
                        Hapus Semua
                    </button>
                </div>
                <div class="card-body">
                    <div id="previewGrid" class="upload-preview-grid"></div>
                </div>
            </div>
        </div>


        {{-- ACTION BUTTONS --}}
        <div class="d-flex justify-content-end gap-2 mt-4">

            <a
                href="{{ route('admin.gallery.show', $gallery) }}"
                class="btn-himapro btn-himapro-secondary"
            >
                Batal
            </a>

            <button
                type="submit"
                class="btn-himapro btn-himapro-primary"
                id="submitBtn"
                disabled
            >
                <i class="bi bi-cloud-upload"></i>
                Upload <span id="submitCount">0</span> Foto
            </button>

        </div>

    </form>

</div>
@endsection


@push('styles')
<style>
/* DROPZONE */
.upload-dropzone {
    border: 2px dashed var(--border-strong);
    border-radius: var(--radius-lg);
    padding: 40px 24px;
    text-align: center;
    background: rgba(255, 255, 255, 0.01);
    transition: all 0.25s ease;
    cursor: pointer;
    position: relative;
}

.upload-dropzone:hover,
.upload-dropzone.dragover {
    border-color: var(--primary);
    background: rgba(255, 210, 26, 0.03);
    box-shadow: 0 0 0 4px rgba(255, 210, 26, 0.05);
}

.upload-dropzone.dragover .upload-dropzone-icon {
    transform: scale(1.1);
    color: var(--primary);
}

.upload-dropzone-icon {
    font-size: 56px;
    color: var(--muted);
    margin-bottom: 16px;
    transition: all 0.25s ease;
}

.upload-dropzone-title {
    font-size: 16px;
    font-weight: 800;
    margin-bottom: 8px;
}

.upload-dropzone-subtitle {
    font-size: 12px;
    color: var(--muted);
    margin-bottom: 12px;
}

.upload-dropzone-hint {
    font-size: 11.5px;
    color: var(--muted);
    margin: 16px 0 0;
    line-height: 1.6;
}

/* PREVIEW GRID */
.upload-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 12px;
}

.upload-preview-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 12px;
    overflow: hidden;
    background: var(--card);
    border: 1px solid var(--border);
    transition: all 0.2s ease;
}

.upload-preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.upload-preview-item:hover {
    border-color: rgba(255, 210, 26, 0.4);
    transform: scale(1.02);
}

.upload-preview-remove {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #fca5a5;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
}

.upload-preview-remove:hover {
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border-color: transparent;
    transform: scale(1.1);
}

.upload-preview-name {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 6px 8px;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
    color: white;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.upload-preview-index {
    position: absolute;
    top: 6px;
    left: 6px;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 210, 26, 0.3);
    color: var(--primary);
    font-size: 10.5px;
    font-weight: 800;
}

/* SUBMIT BUTTON DISABLED */
#submitBtn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

@media (max-width: 767.98px) {
    .upload-preview-grid {
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 8px;
    }

    .upload-dropzone {
        padding: 30px 18px;
    }

    .upload-dropzone-icon {
        font-size: 42px;
    }
}
</style>
@endpush


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const dropzone = document.getElementById('dropzone');
    const input = document.getElementById('filesInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewGrid = document.getElementById('previewGrid');
    const fileCountEl = document.getElementById('fileCount');
    const totalSizeEl = document.getElementById('totalSize');
    const submitBtn = document.getElementById('submitBtn');
    const submitCountEl = document.getElementById('submitCount');

    const MAX_FILES = 10;
    const MAX_SIZE = 5 * 1024 * 1024; // 5 MB

    let selectedFiles = []; // array of File objects

    /*
    |--------------------------------------------------------------------------
    | DROPZONE CLICK
    |--------------------------------------------------------------------------
    */
    dropzone.addEventListener('click', function (e) {
        if (e.target.closest('button')) return;
        input.click();
    });

    /*
    |--------------------------------------------------------------------------
    | INPUT CHANGE
    |--------------------------------------------------------------------------
    */
    input.addEventListener('change', function (e) {
        handleFiles(e.target.files);
        input.value = ''; // reset biar bisa pilih file yang sama lagi
    });

    /*
    |--------------------------------------------------------------------------
    | DRAG & DROP
    |--------------------------------------------------------------------------
    */
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('dragover');
        });
    });

    dropzone.addEventListener('drop', function (e) {
        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    /*
    |--------------------------------------------------------------------------
    | HANDLE FILES
    |--------------------------------------------------------------------------
    */
    function handleFiles(files) {
        const validFiles = [];

        Array.from(files).forEach(file => {
            // Cek total
            if (selectedFiles.length + validFiles.length >= MAX_FILES) {
                showToast('Maksimal ' + MAX_FILES + ' foto per upload', 'error');
                return;
            }

            // Cek tipe
            if (!file.type.startsWith('image/')) {
                showToast('File "' + file.name + '" bukan gambar', 'error');
                return;
            }

            // Cek format
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                showToast('Format "' + file.name + '" tidak didukung', 'error');
                return;
            }

            // Cek ukuran
            if (file.size > MAX_SIZE) {
                showToast('File "' + file.name + '" lebih dari 5 MB', 'error');
                return;
            }

            validFiles.push(file);
        });

        selectedFiles = [...selectedFiles, ...validFiles];

        renderPreview();
        updateStats();
    }

    /*
    |--------------------------------------------------------------------------
    | RENDER PREVIEW
    |--------------------------------------------------------------------------
    */
    function renderPreview() {
        if (selectedFiles.length === 0) {
            previewContainer.classList.add('d-none');
            previewGrid.innerHTML = '';
            return;
        }

        previewContainer.classList.remove('d-none');
        previewGrid.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const url = URL.createObjectURL(file);

            const item = document.createElement('div');
            item.className = 'upload-preview-item';

            item.innerHTML = `
                <img src="${url}" alt="${file.name}">
                <div class="upload-preview-index">${index + 1}</div>
                <div class="upload-preview-name">${escapeHtml(file.name)}</div>
                <button type="button" class="upload-preview-remove" data-index="${index}" title="Hapus">
                    <i class="bi bi-x-lg"></i>
                </button>
            `;

            previewGrid.appendChild(item);

            // Revoke URL after load
            item.querySelector('img').onload = () => URL.revokeObjectURL(url);
        });

        // Attach remove listeners
        previewGrid.querySelectorAll('.upload-preview-remove').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const index = parseInt(this.dataset.index, 10);
                removeFile(index);
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE FILE
    |--------------------------------------------------------------------------
    */
    function removeFile(index) {
        selectedFiles.splice(index, 1);
        renderPreview();
        updateStats();
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAR ALL
    |--------------------------------------------------------------------------
    */
    window.clearAll = function () {
        if (selectedFiles.length === 0) return;

        if (!confirm('Hapus semua foto yang dipilih?')) return;

        selectedFiles = [];
        renderPreview();
        updateStats();
    };

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATS
    |--------------------------------------------------------------------------
    */
    function updateStats() {
        const count = selectedFiles.length;
        const totalSize = selectedFiles.reduce((sum, f) => sum + f.size, 0);

        fileCountEl.textContent = count;
        totalSizeEl.textContent = formatSize(totalSize);
        submitCountEl.textContent = count;

        submitBtn.disabled = count === 0;
    }

    /*
    |--------------------------------------------------------------------------
    | FORMAT SIZE
    |--------------------------------------------------------------------------
    */
    function formatSize(bytes) {
        if (bytes >= 1024 * 1024) {
            return (bytes / 1024 / 1024).toFixed(2) + ' MB';
        }
        if (bytes >= 1024) {
            return (bytes / 1024).toFixed(1) + ' KB';
        }
        return bytes + ' B';
    }

    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */
    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    /*
    |--------------------------------------------------------------------------
    | TOAST NOTIFICATION
    |--------------------------------------------------------------------------
    */
    function showToast(message, type = 'error') {
        const toast = document.createElement('div');
        toast.className = 'landing-toast landing-toast-' + type;
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px)';
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT FORM
    |--------------------------------------------------------------------------
    | Karena input file asli tidak bisa di-set value via JS,
    | kita pakai DataTransfer untuk assign file ke input sebelum submit.
    |--------------------------------------------------------------------------
    */
    document.getElementById('uploadForm').addEventListener('submit', function (e) {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            showToast('Pilih minimal 1 foto', 'error');
            return;
        }

        // Buat DataTransfer untuk assign file ke input asli
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        input.files = dt.files;

        // Disable button biar tidak double submit
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengupload...';
    });

});
</script>
@endpush
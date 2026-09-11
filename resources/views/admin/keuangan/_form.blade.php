<div class="row g-4">

    {{-- SECTION: INFORMASI TRANSAKSI --}}
    <div class="col-12">
        <div class="form-section-title">Informasi Transaksi</div>
    </div>

    <div class="col-md-4">
        <label for="jenis" class="form-label">Jenis Transaksi <span style="color: var(--primary);">*</span></label>
        <select
            id="jenis"
            name="jenis"
            class="form-select @error('jenis') is-invalid @enderror"
            required
        >
            <option value="pemasukan" @selected(old('jenis', $keuangan->jenis ?? 'pengeluaran') === 'pemasukan')>
                Pemasukan
            </option>
            <option value="pengeluaran" @selected(old('jenis', $keuangan->jenis ?? 'pengeluaran') === 'pengeluaran')>
                Pengeluaran
            </option>
        </select>
        @error('jenis')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="tanggal" class="form-label">Tanggal <span style="color: var(--primary);">*</span></label>
        <input
            type="date"
            id="tanggal"
            name="tanggal"
            class="form-control @error('tanggal') is-invalid @enderror"
            value="{{ old('tanggal', isset($keuangan->tanggal) ? $keuangan->tanggal->format('Y-m-d') : date('Y-m-d')) }}"
            required
        >
        @error('tanggal')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="kategori" class="form-label">Kategori <span style="color: var(--primary);">*</span></label>
        <select
            id="kategori"
            name="kategori"
            class="form-select @error('kategori') is-invalid @enderror"
            required
        >
            <option value="">— Pilih Kategori —</option>
            @foreach ($kategoris as $key => $label)
                <option value="{{ $key }}" @selected(old('kategori', $keuangan->kategori ?? '') === $key)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('kategori')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="deskripsi" class="form-label">Deskripsi <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="deskripsi"
            name="deskripsi"
            class="form-control @error('deskripsi') is-invalid @enderror"
            value="{{ old('deskripsi', $keuangan->deskripsi ?? '') }}"
            placeholder="Contoh: Pembelian konsumsi rapat koordinasi"
            required
        >
        @error('deskripsi')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="jumlah" class="form-label">Jumlah <span style="color: var(--primary);">*</span></label>
        <input
            type="number"
            id="jumlah"
            name="jumlah"
            class="form-control @error('jumlah') is-invalid @enderror"
            value="{{ old('jumlah', $keuangan->jumlah ?? 0) }}"
            min="0"
            step="0.01"
            placeholder="0"
            required
        >
        <div id="jumlah-preview" class="form-text" style="color: var(--primary); font-weight: 700;">
            Rp 0
        </div>
        @error('jumlah')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Status <span style="color: var(--primary);">*</span></label>
        <select
            id="status"
            name="status"
            class="form-select @error('status') is-invalid @enderror"
            required
        >
            <option value="pending" @selected(old('status', $keuangan->status ?? 'pending') === 'pending')>
                Pending
            </option>
            <option value="approved" @selected(old('status', $keuangan->status ?? '') === 'approved')>
                Disetujui
            </option>
            <option value="rejected" @selected(old('status', $keuangan->status ?? '') === 'rejected')>
                Ditolak
            </option>
        </select>
        @error('status')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: KETERKAITAN --}}
    <div class="col-12">
        <div class="form-section-title">Keterkaitan</div>
    </div>

    <div class="col-md-6">
        <label for="departemen_id" class="form-label">Departemen</label>
        <select
            id="departemen_id"
            name="departemen_id"
            class="form-select @error('departemen_id') is-invalid @enderror"
        >
            <option value="">— Tidak terkait departemen —</option>
            @foreach ($departemens as $departemen)
                <option value="{{ $departemen->id }}" @selected(old('departemen_id', $keuangan->departemen_id ?? '') == $departemen->id)>
                    {{ $departemen->nama }}
                </option>
            @endforeach
        </select>
        @error('departemen_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="program_kerja_id" class="form-label">Program Kerja</label>
        <select
            id="program_kerja_id"
            name="program_kerja_id"
            class="form-select @error('program_kerja_id') is-invalid @enderror"
        >
            <option value="">— Tidak terkait program kerja —</option>
            @foreach ($programKerjas as $programKerja)
                <option value="{{ $programKerja->id }}" @selected(old('program_kerja_id', $keuangan->program_kerja_id ?? '') == $programKerja->id)>
                    {{ $programKerja->nama }}
                </option>
            @endforeach
        </select>
        @error('program_kerja_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: BUKTI & KETERANGAN --}}
    <div class="col-12">
        <div class="form-section-title">Bukti & Keterangan</div>
    </div>

    <div class="col-md-6">
        <label for="bukti" class="form-label">Bukti Transaksi (opsional)</label>

        @if (isset($keuangan) && $keuangan->bukti_path)
            <div class="photo-preview mb-3">
                <img src="{{ asset('storage/' . $keuangan->bukti_path) }}"
                     alt="Bukti transaksi"
                     style="width: 100%; max-width: 200px; height: auto; max-height: 200px; object-fit: contain;">
                <div class="mt-2" style="font-size: 11px; color: var(--muted);">
                    Bukti saat ini. Pilih file baru untuk mengganti.
                </div>
            </div>
        @endif

        <input
            type="file"
            id="bukti"
            name="bukti"
            class="form-control @error('bukti') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp,image/*"
        >
        <div class="form-text">Format JPG, PNG, WEBP. Maksimal 2 MB.</div>
        @error('bukti')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <div id="bukti-preview-container" class="d-none">
            <label class="form-label">Preview Bukti Baru</label>
            <div class="photo-preview">
                <img id="bukti-preview" src="" alt="Preview"
                     style="width: 100%; max-width: 200px; height: auto; max-height: 200px; object-fit: contain;">
            </div>
        </div>
    </div>

    <div class="col-12">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea
            id="keterangan"
            name="keterangan"
            rows="3"
            class="form-control @error('keterangan') is-invalid @enderror"
            placeholder="Catatan tambahan tentang transaksi ini..."
        >{{ old('keterangan', $keuangan->keterangan ?? '') }}</textarea>
        @error('keterangan')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.keuangan.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($keuangan) ? 'Simpan Perubahan' : 'Simpan Transaksi' }}
    </button>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Preview jumlah
    const jumlahInput = document.getElementById('jumlah');
    const jumlahPreview = document.getElementById('jumlah-preview');

    if (jumlahInput && jumlahPreview) {
        function updatePreview() {
            const value = parseFloat(jumlahInput.value) || 0;
            jumlahPreview.textContent = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value);
        }

        jumlahInput.addEventListener('input', updatePreview);
        updatePreview();
    }

    // Preview bukti
    const buktiInput = document.getElementById('bukti');
    const buktiContainer = document.getElementById('bukti-preview-container');
    const buktiImg = document.getElementById('bukti-preview');

    if (buktiInput && buktiContainer && buktiImg) {
        buktiInput.addEventListener('change', function (e) {
            const file = e.target.files[0];

            if (!file || !file.type.startsWith('image/')) {
                buktiContainer.classList.add('d-none');
                buktiImg.src = '';
                return;
            }

            const url = URL.createObjectURL(file);
            buktiImg.src = url;
            buktiContainer.classList.remove('d-none');

            buktiImg.onload = () => URL.revokeObjectURL(url);
        });
    }

});
</script>
@endpush
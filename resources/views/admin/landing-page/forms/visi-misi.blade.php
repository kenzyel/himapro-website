@php
    $c = $content;
    $misi = $c['misi'] ?? [];
@endphp

<div class="row g-4">

    <div class="col-12">
        <label class="form-label">Judul Header</label>
        <input type="text" name="content[title]" class="form-control"
               value="{{ old('content.title', $c['title'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <label class="form-label">Deskripsi Header</label>
        <textarea name="content[description]" rows="2" class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.description', $c['description'] ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <div class="form-section-title">Visi</div>
    </div>

    <div class="col-12">
        <label class="form-label">Teks Visi</label>
        <textarea name="content[visi]" rows="4" class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.visi', $c['visi'] ?? '') }}</textarea>
        <div class="form-text">Boleh HTML <code>&lt;span class="accent"&gt;...&lt;/span&gt;</code></div>
    </div>

    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div class="form-section-title" style="margin-bottom: 0;">Misi (bisa tambah/hapus)</div>
        </div>
    </div>

    <div class="col-12">
        <div id="misi-list">
            @foreach ($misi as $i => $m)
                <div class="p-3 mb-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                            Misi {{ $i + 1 }}
                        </div>
                        @if ($canUpdate)
                            <button type="button" class="btn-icon danger" onclick="this.closest('.p-3').remove()" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        @endif
                    </div>

                    <label class="form-label" style="font-size: 11px;">Judul</label>
                    <input type="text" name="content[misi][{{ $i }}][title]" class="form-control mb-2"
                           value="{{ old("content.misi.$i.title", $m['title'] ?? '') }}"
                           {{ $canUpdate ? '' : 'readonly' }}>

                    <label class="form-label" style="font-size: 11px;">Deskripsi</label>
                    <textarea name="content[misi][{{ $i }}][description]" rows="3" class="form-control"
                              {{ $canUpdate ? '' : 'readonly' }}>{{ old("content.misi.$i.description", $m['description'] ?? '') }}</textarea>
                </div>
            @endforeach
        </div>

        @if ($canUpdate)
            <button type="button" class="btn-himapro btn-himapro-secondary" onclick="addMisi()">
                <i class="bi bi-plus-lg"></i>
                Tambah Misi
            </button>
        @endif
    </div>

</div>

@push('scripts')
@if ($canUpdate)
<script>
function addMisi() {
    const list = document.getElementById('misi-list');
    const index = list.querySelectorAll('.p-3').length;

    const html = `
        <div class="p-3 mb-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                    Misi Baru
                </div>
                <button type="button" class="btn-icon danger" onclick="this.closest('.p-3').remove()" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <label class="form-label" style="font-size: 11px;">Judul</label>
            <input type="text" name="content[misi][${index}][title]" class="form-control mb-2">

            <label class="form-label" style="font-size: 11px;">Deskripsi</label>
            <textarea name="content[misi][${index}][description]" rows="3" class="form-control"></textarea>
        </div>
    `;

    list.insertAdjacentHTML('beforeend', html);
}
</script>
@endif
@endpush
@php $c = $content; @endphp

<div class="row g-4">

    <div class="col-md-6">
        <label class="form-label">Label Kecil</label>
        <input type="text" name="content[label]" class="form-control"
               value="{{ old('content.label', $c['label'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Jumlah Tampil</label>
        <input type="number" name="content[limit]" class="form-control"
               value="{{ old('content.limit', $c['limit'] ?? 4) }}"
               min="1" max="12"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <label class="form-label">Judul Section</label>
        <input type="text" name="content[title]" class="form-control"
               value="{{ old('content.title', $c['title'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="content[description]" rows="3" class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.description', $c['description'] ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Teks Tombol "Lihat Semua"</label>
        <input type="text" name="content[cta_text]" class="form-control"
               value="{{ old('content.cta_text', $c['cta_text'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Link Tombol "Lihat Semua"</label>
        <input type="text" name="content[cta_link]" class="form-control"
               value="{{ old('content.cta_link', $c['cta_link'] ?? '/gallery') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

</div>
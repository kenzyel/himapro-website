@php $c = $content; @endphp

<div class="row g-4">

    <div class="col-md-6">
        <label class="form-label">Label Kecil</label>
        <input type="text" name="content[label]" class="form-control"
               value="{{ old('content.label', $c['label'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <label class="form-label">Judul</label>
        <input type="text" name="content[title]" class="form-control"
               value="{{ old('content.title', $c['title'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
        <div class="form-text">Boleh pakai HTML <code>&lt;span class="accent"&gt;...&lt;/span&gt;</code></div>
    </div>

    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="content[description]" rows="3" class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.description', $c['description'] ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tombol 1 — Teks</label>
        <input type="text" name="content[cta1_text]" class="form-control"
               value="{{ old('content.cta1_text', $c['cta1_text'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tombol 1 — Link</label>
        <input type="text" name="content[cta1_link]" class="form-control"
               value="{{ old('content.cta1_link', $c['cta1_link'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tombol 2 — Teks</label>
        <input type="text" name="content[cta2_text]" class="form-control"
               value="{{ old('content.cta2_text', $c['cta2_text'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tombol 2 — Link</label>
        <input type="text" name="content[cta2_link]" class="form-control"
               value="{{ old('content.cta2_link', $c['cta2_link'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

</div>
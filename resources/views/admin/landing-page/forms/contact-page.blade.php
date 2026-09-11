@php $c = $content; @endphp

<div class="row g-4">

    <div class="col-12">
        <div class="form-section-title">Header Halaman</div>
    </div>

    <div class="col-12">
        <label class="form-label">Judul Header</label>
        <input type="text" name="content[title]" class="form-control"
               value="{{ old('content.title', $c['title'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
        <div class="form-text">Boleh HTML <code>&lt;span class="accent"&gt;...&lt;/span&gt;</code></div>
    </div>

    <div class="col-12">
        <label class="form-label">Deskripsi Header</label>
        <textarea name="content[description]" rows="2" class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.description', $c['description'] ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <div class="form-section-title">Form Kontak</div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Judul Form</label>
        <input type="text" name="content[form_title]" class="form-control"
               value="{{ old('content.form_title', $c['form_title'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Deskripsi Form</label>
        <input type="text" name="content[form_description]" class="form-control"
               value="{{ old('content.form_description', $c['form_description'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <div class="alert alert-warning" style="margin-top: 8px;">
            <i class="bi bi-info-circle-fill"></i>
            <div>
                <strong>Info Kontak</strong> (alamat, email, telepon, jam) diambil dari <a href="{{ route('admin.settings.index') }}" style="color: var(--primary);">Pengaturan</a>.
                <br>
                <strong>Google Maps</strong> juga diatur di <a href="{{ route('admin.settings.index') }}" style="color: var(--primary);">Pengaturan</a> → <code>contact_maps_embed</code>.
            </div>
        </div>
    </div>

</div>
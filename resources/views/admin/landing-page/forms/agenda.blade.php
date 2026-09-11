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
               value="{{ old('content.limit', $c['limit'] ?? 3) }}"
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

</div>
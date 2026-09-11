@php $c = $content; @endphp

<div class="row g-4">

    <div class="col-md-6">
        <label class="form-label">Label Kecil</label>
        <input type="text" name="content[label]" class="form-control"
               value="{{ old('content.label', $c['label'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <label class="form-label">Judul Section</label>
        <input type="text" name="content[title]" class="form-control"
               value="{{ old('content.title', $c['title'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

</div>
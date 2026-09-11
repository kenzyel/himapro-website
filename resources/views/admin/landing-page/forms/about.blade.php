@php
    $c = $content;
    $features = $c['features'] ?? [
        ['icon' => 'bi-check-lg', 'title' => '', 'description' => ''],
        ['icon' => 'bi-check-lg', 'title' => '', 'description' => ''],
        ['icon' => 'bi-check-lg', 'title' => '', 'description' => ''],
    ];
@endphp

<div class="row g-4">

    <div class="col-md-6">
        <label class="form-label">Label Kecil</label>
        <input type="text"
               name="content[label]"
               class="form-control"
               value="{{ old('content.label', $c['label'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <label class="form-label">Judul Section</label>
        <input type="text"
               name="content[title]"
               class="form-control"
               value="{{ old('content.title', $c['title'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
        <div class="form-text">Boleh pakai HTML <code>&lt;span class="accent"&gt;...&lt;/span&gt;</code></div>
    </div>

    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="content[description]"
                  rows="4"
                  class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.description', $c['description'] ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <div class="form-section-title">Poin Keunggulan (3 item)</div>
    </div>

    @foreach ($features as $index => $feature)
        <div class="col-md-4">
            <div class="p-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
                <div class="mb-2" style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                    Poin {{ $index + 1 }}
                </div>

                <label class="form-label" style="font-size: 11px;">Icon (Bootstrap Icons)</label>
                <input type="text"
                       name="content[features][{{ $index }}][icon]"
                       class="form-control mb-2"
                       value="{{ old("content.features.$index.icon", $feature['icon'] ?? 'bi-check-lg') }}"
                       placeholder="bi-check-lg"
                       {{ $canUpdate ? '' : 'readonly' }}>

                <label class="form-label" style="font-size: 11px;">Judul</label>
                <input type="text"
                       name="content[features][{{ $index }}][title]"
                       class="form-control mb-2"
                       value="{{ old("content.features.$index.title", $feature['title'] ?? '') }}"
                       {{ $canUpdate ? '' : 'readonly' }}>

                <label class="form-label" style="font-size: 11px;">Deskripsi</label>
                <textarea name="content[features][{{ $index }}][description]"
                          rows="3"
                          class="form-control"
                          {{ $canUpdate ? '' : 'readonly' }}>{{ old("content.features.$index.description", $feature['description'] ?? '') }}</textarea>
            </div>
        </div>
    @endforeach

    <div class="col-12">
        <div class="form-section-title">Quote & Statistik</div>
    </div>

    <div class="col-12">
        <label class="form-label">Quote</label>
        <input type="text"
               name="content[quote]"
               class="form-control"
               value="{{ old('content.quote', $c['quote'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Author Quote</label>
        <input type="text"
               name="content[quote_author]"
               class="form-control"
               value="{{ old('content.quote_author', $c['quote_author'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-3">
        <label class="form-label">Stat 1 — Value</label>
        <input type="text"
               name="content[stat1_value]"
               class="form-control"
               value="{{ old('content.stat1_value', $c['stat1_value'] ?? '') }}"
               placeholder="100+"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-3">
        <label class="form-label">Stat 1 — Label</label>
        <input type="text"
               name="content[stat1_label]"
               class="form-control"
               value="{{ old('content.stat1_label', $c['stat1_label'] ?? '') }}"
               placeholder="Mahasiswa Terlibat"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-3">
        <label class="form-label">Stat 2 — Value</label>
        <input type="text"
               name="content[stat2_value]"
               class="form-control"
               value="{{ old('content.stat2_value', $c['stat2_value'] ?? '') }}"
               placeholder="20+"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-3">
        <label class="form-label">Stat 2 — Label</label>
        <input type="text"
               name="content[stat2_label]"
               class="form-control"
               value="{{ old('content.stat2_label', $c['stat2_label'] ?? '') }}"
               placeholder="Program Terlaksana"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

</div>
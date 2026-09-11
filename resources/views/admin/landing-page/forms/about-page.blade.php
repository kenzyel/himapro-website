@php
    $c = $content;
    $paragraphs = $c['intro_paragraphs'] ?? ['', '', ''];
    $values = $c['values'] ?? [
        ['icon' => 'bi-people-fill', 'title' => '', 'description' => ''],
        ['icon' => 'bi-lightbulb-fill', 'title' => '', 'description' => ''],
        ['icon' => 'bi-rocket-takeoff-fill', 'title' => '', 'description' => ''],
    ];
@endphp

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
        <textarea name="content[description]" rows="3" class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.description', $c['description'] ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <div class="form-section-title">Pengantar (Intro)</div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Label Kecil</label>
        <input type="text" name="content[intro_label]" class="form-control"
               value="{{ old('content.intro_label', $c['intro_label'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Judul Intro</label>
        <input type="text" name="content[intro_title]" class="form-control"
               value="{{ old('content.intro_title', $c['intro_title'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    @foreach ($paragraphs as $i => $p)
        <div class="col-12">
            <label class="form-label">Paragraf {{ $i + 1 }}</label>
            <textarea name="content[intro_paragraphs][{{ $i }}]" rows="3" class="form-control"
                      {{ $canUpdate ? '' : 'readonly' }}>{{ old("content.intro_paragraphs.$i", $p) }}</textarea>
        </div>
    @endforeach

    <div class="col-12">
        <div class="form-section-title">Nilai-Nilai (3 item)</div>
    </div>

    @foreach ($values as $i => $v)
        <div class="col-md-4">
            <div class="p-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
                <div class="mb-2" style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                    Nilai {{ $i + 1 }}
                </div>

                <label class="form-label" style="font-size: 11px;">Icon</label>
                <input type="text" name="content[values][{{ $i }}][icon]" class="form-control mb-2"
                       value="{{ old("content.values.$i.icon", $v['icon'] ?? '') }}"
                       placeholder="bi-people-fill"
                       {{ $canUpdate ? '' : 'readonly' }}>

                <label class="form-label" style="font-size: 11px;">Judul</label>
                <input type="text" name="content[values][{{ $i }}][title]" class="form-control mb-2"
                       value="{{ old("content.values.$i.title", $v['title'] ?? '') }}"
                       {{ $canUpdate ? '' : 'readonly' }}>

                <label class="form-label" style="font-size: 11px;">Deskripsi</label>
                <textarea name="content[values][{{ $i }}][description]" rows="3" class="form-control"
                          {{ $canUpdate ? '' : 'readonly' }}>{{ old("content.values.$i.description", $v['description'] ?? '') }}</textarea>
            </div>
        </div>
    @endforeach

</div>
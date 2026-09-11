@php
    $c = $content;
    $timeline = $c['timeline'] ?? [];
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
        <label class="form-label">Paragraf Intro</label>
        <textarea name="content[intro]" rows="4" class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.intro', $c['intro'] ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Label Timeline</label>
        <input type="text" name="content[timeline_label]" class="form-control"
               value="{{ old('content.timeline_label', $c['timeline_label'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Judul Timeline</label>
        <input type="text" name="content[timeline_title]" class="form-control"
               value="{{ old('content.timeline_title', $c['timeline_title'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <div class="form-section-title">Timeline (bisa tambah/hapus)</div>
    </div>

    <div class="col-12">
        <div id="timeline-list">
            @foreach ($timeline as $i => $t)
                <div class="p-3 mb-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                            Titik {{ $i + 1 }}
                        </div>
                        @if ($canUpdate)
                            <button type="button" class="btn-icon danger" onclick="this.closest('.p-3').remove()" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        @endif
                    </div>

                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label" style="font-size: 11px;">Tahun / Label</label>
                            <input type="text" name="content[timeline][{{ $i }}][year]" class="form-control"
                                   value="{{ old("content.timeline.$i.year", $t['year'] ?? '') }}"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label" style="font-size: 11px;">Judul</label>
                            <input type="text" name="content[timeline][{{ $i }}][title]" class="form-control"
                                   value="{{ old("content.timeline.$i.title", $t['title'] ?? '') }}"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="font-size: 11px;">Deskripsi</label>
                            <textarea name="content[timeline][{{ $i }}][description]" rows="3" class="form-control"
                                      {{ $canUpdate ? '' : 'readonly' }}>{{ old("content.timeline.$i.description", $t['description'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($canUpdate)
            <button type="button" class="btn-himapro btn-himapro-secondary" onclick="addTimeline()">
                <i class="bi bi-plus-lg"></i>
                Tambah Titik Timeline
            </button>
        @endif
    </div>

</div>

@push('scripts')
@if ($canUpdate)
<script>
function addTimeline() {
    const list = document.getElementById('timeline-list');
    const index = list.querySelectorAll('.p-3').length;

    const html = `
        <div class="p-3 mb-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                    Titik Baru
                </div>
                <button type="button" class="btn-icon danger" onclick="this.closest('.p-3').remove()" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label" style="font-size: 11px;">Tahun / Label</label>
                    <input type="text" name="content[timeline][${index}][year]" class="form-control">
                </div>

                <div class="col-md-8">
                    <label class="form-label" style="font-size: 11px;">Judul</label>
                    <input type="text" name="content[timeline][${index}][title]" class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label" style="font-size: 11px;">Deskripsi</label>
                    <textarea name="content[timeline][${index}][description]" rows="3" class="form-control"></textarea>
                </div>
            </div>
        </div>
    `;

    list.insertAdjacentHTML('beforeend', html);
}
</script>
@endif
@endpush
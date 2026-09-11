@php
    $c = $content;
    $cards = $c['floating_cards'] ?? [
        ['icon' => 'bi-code-slash', 'title' => '', 'description' => '', 'color' => 'primary', 'is_active' => true],
        ['icon' => 'bi-lightbulb-fill', 'title' => '', 'description' => '', 'color' => 'green', 'is_active' => true],
        ['icon' => 'bi-rocket-takeoff-fill', 'title' => '', 'description' => '', 'color' => 'blue', 'is_active' => true],
    ];

    $colorOptions = [
        'primary' => 'Kuning (Primary)',
        'green' => 'Hijau',
        'blue' => 'Biru',
        'purple' => 'Ungu',
        'orange' => 'Oranye',
        'pink' => 'Pink',
        'red' => 'Merah',
    ];
@endphp

<div class="row g-4">

    <div class="col-12">
        <div class="form-section-title">Header Hero</div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Label Kecil (di atas judul)</label>
        <input type="text"
               name="content[label]"
               class="form-control"
               value="{{ old('content.label', $c['label'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Background Type</label>
        <select name="content[background_type]" class="form-select" {{ $canUpdate ? '' : 'disabled' }}>
            <option value="gradient" @selected(($c['background_type'] ?? 'gradient') === 'gradient')>Gradient</option>
            <option value="image" @selected(($c['background_type'] ?? '') === 'image')>Gambar</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Judul Utama</label>
        <textarea name="content[title]"
                  rows="2"
                  class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.title', $c['title'] ?? '') }}</textarea>
        <div class="form-text">Boleh pakai HTML, contoh: <code>&lt;span class="accent"&gt;Highlight&lt;/span&gt;</code></div>
    </div>

    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="content[description]"
                  rows="3"
                  class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.description', $c['description'] ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tombol 1 — Teks</label>
        <input type="text"
               name="content[cta1_text]"
               class="form-control"
               value="{{ old('content.cta1_text', $c['cta1_text'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tombol 1 — Link</label>
        <input type="text"
               name="content[cta1_link]"
               class="form-control"
               value="{{ old('content.cta1_link', $c['cta1_link'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tombol 2 — Teks</label>
        <input type="text"
               name="content[cta2_text]"
               class="form-control"
               value="{{ old('content.cta2_text', $c['cta2_text'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tombol 2 — Link</label>
        <input type="text"
               name="content[cta2_link]"
               class="form-control"
               value="{{ old('content.cta2_link', $c['cta2_link'] ?? '') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <label class="form-label d-block">Tampilkan Statistik?</label>
        <input type="hidden" name="content[show_stats]" value="0">
        <div class="form-check form-switch">
            <input class="form-check-input"
                   type="checkbox"
                   name="content[show_stats]"
                   value="1"
                   id="show_stats_hero"
                   @checked(($c['show_stats'] ?? true) == 1)
                   {{ $canUpdate ? '' : 'disabled' }}>
            <label class="form-check-label" for="show_stats_hero">
                Tampilkan statistik (jumlah pengurus, departemen, dll.)
            </label>
        </div>
    </div>


    {{-- FLOATING CARDS --}}
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border);">
            <div>
                <div class="form-section-title" style="margin-bottom: 4px;">Kartu Melayang (Floating Cards)</div>
                <p style="font-size: 12px; color: var(--muted); margin: 0;">
                    Kartu yang muncul di sisi kanan hero. Hanya <strong>3 kartu pertama yang aktif</strong> yang ditampilkan.
                </p>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div id="floating-cards-list">

            @foreach ($cards as $i => $card)
                <div class="p-3 mb-3 floating-card-item" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                            Kartu <span class="card-number">{{ $i + 1 }}</span>
                        </div>

                        @if ($canUpdate)
                            <button type="button"
                                    class="btn-icon danger"
                                    onclick="removeFloatingCard(this)"
                                    title="Hapus Kartu">
                                <i class="bi bi-trash"></i>
                            </button>
                        @endif
                    </div>

                    <div class="row g-3">

                        {{-- Icon --}}
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 11px;">Icon (Bootstrap Icons)</label>
                            <input type="text"
                                   name="content[floating_cards][{{ $i }}][icon]"
                                   class="form-control"
                                   value="{{ old("content.floating_cards.$i.icon", $card['icon'] ?? '') }}"
                                   placeholder="bi-code-slash"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                            <div class="form-text" style="font-size: 10px;">
                                Lihat di <a href="https://icons.getbootstrap.com/" target="_blank" style="color: var(--primary);">icons.getbootstrap.com</a>
                            </div>
                        </div>

                        {{-- Warna --}}
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 11px;">Warna Icon</label>
                            <select name="content[floating_cards][{{ $i }}][color]"
                                    class="form-select"
                                    {{ $canUpdate ? '' : 'disabled' }}>
                                @foreach ($colorOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old("content.floating_cards.$i.color", $card['color'] ?? 'primary') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Judul --}}
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 11px;">Judul</label>
                            <input type="text"
                                   name="content[floating_cards][{{ $i }}][title]"
                                   class="form-control"
                                   value="{{ old("content.floating_cards.$i.title", $card['title'] ?? '') }}"
                                   placeholder="Kolaborasi"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-md-6">
                            <label class="form-label" style="font-size: 11px;">Deskripsi</label>
                            <input type="text"
                                   name="content[floating_cards][{{ $i }}][description]"
                                   class="form-control"
                                   value="{{ old("content.floating_cards.$i.description", $card['description'] ?? '') }}"
                                   placeholder="Tumbuh bersama"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                        </div>

                        {{-- Aktif --}}
                        <div class="col-12">
                            <input type="hidden" name="content[floating_cards][{{ $i }}][is_active]" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="content[floating_cards][{{ $i }}][is_active]"
                                       value="1"
                                       id="card_active_{{ $i }}"
                                       @checked(old("content.floating_cards.$i.is_active", $card['is_active'] ?? true) == 1)
                                       {{ $canUpdate ? '' : 'disabled' }}>
                                <label class="form-check-label" for="card_active_{{ $i }}" style="font-size: 12.5px;">
                                    Tampilkan kartu ini
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        @if ($canUpdate)
            <button type="button" class="btn-himapro btn-himapro-secondary" onclick="addFloatingCard()">
                <i class="bi bi-plus-lg"></i>
                Tambah Kartu
            </button>
        @endif
    </div>

</div>


@push('scripts')
@if ($canUpdate)
<script>
const colorOptionsHtml = `
    <option value="primary">Kuning (Primary)</option>
    <option value="green">Hijau</option>
    <option value="blue">Biru</option>
    <option value="purple">Ungu</option>
    <option value="orange">Oranye</option>
    <option value="pink">Pink</option>
    <option value="red">Merah</option>
`;

function addFloatingCard() {
    const list = document.getElementById('floating-cards-list');
    const index = list.querySelectorAll('.floating-card-item').length;

    const html = `
        <div class="p-3 mb-3 floating-card-item" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                    Kartu <span class="card-number">${index + 1}</span>
                </div>
                <button type="button" class="btn-icon danger" onclick="removeFloatingCard(this)" title="Hapus Kartu">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" style="font-size: 11px;">Icon (Bootstrap Icons)</label>
                    <input type="text" name="content[floating_cards][${index}][icon]" class="form-control" placeholder="bi-code-slash">
                </div>

                <div class="col-md-6">
                    <label class="form-label" style="font-size: 11px;">Warna Icon</label>
                    <select name="content[floating_cards][${index}][color]" class="form-select">
                        ${colorOptionsHtml}
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label" style="font-size: 11px;">Judul</label>
                    <input type="text" name="content[floating_cards][${index}][title]" class="form-control" placeholder="Kolaborasi">
                </div>

                <div class="col-md-6">
                    <label class="form-label" style="font-size: 11px;">Deskripsi</label>
                    <input type="text" name="content[floating_cards][${index}][description]" class="form-control" placeholder="Tumbuh bersama">
                </div>

                <div class="col-12">
                    <input type="hidden" name="content[floating_cards][${index}][is_active]" value="0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="content[floating_cards][${index}][is_active]" value="1" id="card_active_${index}" checked>
                        <label class="form-check-label" for="card_active_${index}" style="font-size: 12.5px;">
                            Tampilkan kartu ini
                        </label>
                    </div>
                </div>
            </div>
        </div>
    `;

    list.insertAdjacentHTML('beforeend', html);
    renumberCards();
}

function removeFloatingCard(btn) {
    btn.closest('.floating-card-item').remove();
    renumberCards();
}

function renumberCards() {
    const list = document.getElementById('floating-cards-list');
    list.querySelectorAll('.floating-card-item').forEach((item, i) => {
        const numberEl = item.querySelector('.card-number');
        if (numberEl) {
            numberEl.textContent = i + 1;
        }
    });
}
</script>
@endif
@endpush
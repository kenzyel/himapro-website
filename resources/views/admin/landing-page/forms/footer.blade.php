@php
    $c = $content;
    $navMenu = $c['nav_menu'] ?? [];
    $programMenu = $c['program_menu'] ?? [];
@endphp

<div class="row g-4">

    {{-- DESKRIPSI --}}
    <div class="col-12">
        <div class="form-section-title">Brand & Deskripsi</div>
    </div>

    <div class="col-12">
        <label class="form-label">Deskripsi Footer</label>
        <textarea name="content[description]"
                  rows="3"
                  class="form-control"
                  {{ $canUpdate ? '' : 'readonly' }}>{{ old('content.description', $c['description'] ?? '') }}</textarea>
        <div class="form-text">Tampil di bawah brand di footer.</div>
    </div>


    {{-- NAV MENU --}}
    <div class="col-12" style="border-top: 1px solid var(--border); padding-top: 24px;">
        <div class="form-section-title">Kolom Navigasi</div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Label Kolom</label>
        <input type="text"
               name="content[nav_label]"
               class="form-control"
               value="{{ old('content.nav_label', $c['nav_label'] ?? 'Navigasi') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <div id="footerNavList">
            @foreach ($navMenu as $i => $item)
                <div class="footer-nav-item p-3 mb-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                            Menu <span class="footer-nav-number">{{ $i + 1 }}</span>
                        </div>
                        @if ($canUpdate)
                            <button type="button" class="btn-icon danger" onclick="removeFooterNav(this)" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        @endif
                    </div>

                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label" style="font-size: 11px;">Label</label>
                            <input type="text" name="content[nav_menu][{{ $i }}][label]" class="form-control"
                                   value="{{ old("content.nav_menu.$i.label", $item['label'] ?? '') }}"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label" style="font-size: 11px;">Link</label>
                            <input type="text" name="content[nav_menu][{{ $i }}][link]" class="form-control"
                                   value="{{ old("content.nav_menu.$i.link", $item['link'] ?? '') }}"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <input type="hidden" name="content[nav_menu][{{ $i }}][is_active]" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                       name="content[nav_menu][{{ $i }}][is_active]" value="1"
                                       id="footer_nav_{{ $i }}"
                                       @checked(old("content.nav_menu.$i.is_active", $item['is_active'] ?? true) == 1)
                                       {{ $canUpdate ? '' : 'disabled' }}>
                                <label class="form-check-label" for="footer_nav_{{ $i }}" style="font-size: 11px;">
                                    Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($canUpdate)
            <button type="button" class="btn-himapro btn-himapro-secondary" onclick="addFooterNav()">
                <i class="bi bi-plus-lg"></i>
                Tambah Menu Navigasi
            </button>
        @endif
    </div>


    {{-- PROGRAM MENU --}}
    <div class="col-12" style="border-top: 1px solid var(--border); padding-top: 24px;">
        <div class="form-section-title">Kolom Program</div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Label Kolom</label>
        <input type="text"
               name="content[program_label]"
               class="form-control"
               value="{{ old('content.program_label', $c['program_label'] ?? 'Program') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <div id="footerProgramList">
            @foreach ($programMenu as $i => $item)
                <div class="footer-program-item p-3 mb-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                            Program <span class="footer-program-number">{{ $i + 1 }}</span>
                        </div>
                        @if ($canUpdate)
                            <button type="button" class="btn-icon danger" onclick="removeFooterProgram(this)" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        @endif
                    </div>

                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label" style="font-size: 11px;">Label</label>
                            <input type="text" name="content[program_menu][{{ $i }}][label]" class="form-control"
                                   value="{{ old("content.program_menu.$i.label", $item['label'] ?? '') }}"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label" style="font-size: 11px;">Link</label>
                            <input type="text" name="content[program_menu][{{ $i }}][link]" class="form-control"
                                   value="{{ old("content.program_menu.$i.link", $item['link'] ?? '') }}"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <input type="hidden" name="content[program_menu][{{ $i }}][is_active]" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                       name="content[program_menu][{{ $i }}][is_active]" value="1"
                                       id="footer_program_{{ $i }}"
                                       @checked(old("content.program_menu.$i.is_active", $item['is_active'] ?? true) == 1)
                                       {{ $canUpdate ? '' : 'disabled' }}>
                                <label class="form-check-label" for="footer_program_{{ $i }}" style="font-size: 11px;">
                                    Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($canUpdate)
            <button type="button" class="btn-himapro btn-himapro-secondary" onclick="addFooterProgram()">
                <i class="bi bi-plus-lg"></i>
                Tambah Program
            </button>
        @endif
    </div>


    {{-- KONTAK --}}
    <div class="col-12" style="border-top: 1px solid var(--border); padding-top: 24px;">
        <div class="form-section-title">Kolom Kontak</div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Label Kolom</label>
        <input type="text"
               name="content[contact_label]"
               class="form-control"
               value="{{ old('content.contact_label', $c['contact_label'] ?? 'Kontak') }}"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-12">
        <div class="alert alert-warning" style="font-size: 12.5px;">
            <i class="bi bi-info-circle-fill me-2"></i>
            <div>
                <strong>Info kontak</strong> (alamat, email, telepon, jam operasional) diambil otomatis dari
                <a href="{{ route('admin.settings.index') }}" style="color: var(--primary);">Pengaturan</a> → grup <code>contact</code>.
                <br>
                <strong>Sosial media</strong> juga dari Pengaturan → grup <code>social</code>.
            </div>
        </div>
    </div>

    <div class="col-12">
        <input type="hidden" name="content[show_sosial]" value="0">
        <div class="form-check form-switch">
            <input class="form-check-input"
                   type="checkbox"
                   name="content[show_sosial]"
                   value="1"
                   id="footer_show_sosial"
                   @checked(old('content.show_sosial', $c['show_sosial'] ?? true) == 1)
                   {{ $canUpdate ? '' : 'disabled' }}>
            <label class="form-check-label" for="footer_show_sosial" style="font-size: 13px;">
                Tampilkan sosial media di footer
            </label>
        </div>
    </div>

</div>


@push('scripts')
@if ($canUpdate)
<script>
/* NAV MENU */
function addFooterNav() {
    const list = document.getElementById('footerNavList');
    const index = list.querySelectorAll('.footer-nav-item').length;

    const html = `
        <div class="footer-nav-item p-3 mb-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                    Menu <span class="footer-nav-number">${index + 1}</span>
                </div>
                <button type="button" class="btn-icon danger" onclick="removeFooterNav(this)" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label" style="font-size: 11px;">Label</label>
                    <input type="text" name="content[nav_menu][${index}][label]" class="form-control">
                </div>
                <div class="col-md-5">
                    <label class="form-label" style="font-size: 11px;">Link</label>
                    <input type="text" name="content[nav_menu][${index}][link]" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <input type="hidden" name="content[nav_menu][${index}][is_active]" value="0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="content[nav_menu][${index}][is_active]" value="1" id="footer_nav_${index}" checked>
                        <label class="form-check-label" for="footer_nav_${index}" style="font-size: 11px;">Aktif</label>
                    </div>
                </div>
            </div>
        </div>
    `;

    list.insertAdjacentHTML('beforeend', html);
    renumberFooterNav();
}

function removeFooterNav(btn) {
    btn.closest('.footer-nav-item').remove();
    renumberFooterNav();
}

function renumberFooterNav() {
    document.querySelectorAll('#footerNavList .footer-nav-item').forEach((item, i) => {
        const el = item.querySelector('.footer-nav-number');
        if (el) el.textContent = i + 1;
    });
}

/* PROGRAM MENU */
function addFooterProgram() {
    const list = document.getElementById('footerProgramList');
    const index = list.querySelectorAll('.footer-program-item').length;

    const html = `
        <div class="footer-program-item p-3 mb-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                    Program <span class="footer-program-number">${index + 1}</span>
                </div>
                <button type="button" class="btn-icon danger" onclick="removeFooterProgram(this)" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label" style="font-size: 11px;">Label</label>
                    <input type="text" name="content[program_menu][${index}][label]" class="form-control">
                </div>
                <div class="col-md-5">
                    <label class="form-label" style="font-size: 11px;">Link</label>
                    <input type="text" name="content[program_menu][${index}][link]" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <input type="hidden" name="content[program_menu][${index}][is_active]" value="0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="content[program_menu][${index}][is_active]" value="1" id="footer_program_${index}" checked>
                        <label class="form-check-label" for="footer_program_${index}" style="font-size: 11px;">Aktif</label>
                    </div>
                </div>
            </div>
        </div>
    `;

    list.insertAdjacentHTML('beforeend', html);
    renumberFooterProgram();
}

function removeFooterProgram(btn) {
    btn.closest('.footer-program-item').remove();
    renumberFooterProgram();
}

function renumberFooterProgram() {
    document.querySelectorAll('#footerProgramList .footer-program-item').forEach((item, i) => {
        const el = item.querySelector('.footer-program-number');
        if (el) el.textContent = i + 1;
    });
}
</script>
@endif
@endpush
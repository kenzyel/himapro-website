@php
    $c = $content;
    $menu = $c['menu'] ?? [];
@endphp

<div class="row g-4">

    <div class="col-12">
        <div class="form-section-title">Brand</div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Teks Brand</label>
        <input type="text"
               name="content[brand_text]"
               class="form-control"
               value="{{ old('content.brand_text', $c['brand_text'] ?? '') }}"
               placeholder="HIMAPRO TI"
               {{ $canUpdate ? '' : 'readonly' }}>
        <div class="form-text">Muncul di sebelah logo.</div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tagline Brand</label>
        <input type="text"
               name="content[brand_tagline]"
               class="form-control"
               value="{{ old('content.brand_tagline', $c['brand_tagline'] ?? '') }}"
               placeholder="SAKTI"
               {{ $canUpdate ? '' : 'readonly' }}>
        <div class="form-text">Teks kecil di bawah brand.</div>
    </div>


    {{-- MENU --}}
    <div class="col-12" style="border-top: 1px solid var(--border); padding-top: 24px;">
        <div class="form-section-title">Menu Navigasi</div>
        <p style="font-size: 12px; color: var(--muted); margin-top: -8px; margin-bottom: 16px;">
            Menu yang muncul di navbar. Bisa tambah/hapus, aktif/non-aktif.
        </p>
    </div>

    <div class="col-12">
        <div id="navbarMenuList">

            @foreach ($menu as $i => $item)
                <div class="navbar-menu-item p-3 mb-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                            Menu <span class="navbar-menu-number">{{ $i + 1 }}</span>
                        </div>

                        @if ($canUpdate)
                            <button type="button"
                                    class="btn-icon danger"
                                    onclick="removeNavbarMenu(this)"
                                    title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        @endif
                    </div>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label" style="font-size: 11px;">Label</label>
                            <input type="text"
                                   name="content[menu][{{ $i }}][label]"
                                   class="form-control"
                                   value="{{ old("content.menu.$i.label", $item['label'] ?? '') }}"
                                   placeholder="Beranda"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" style="font-size: 11px;">Link</label>
                            <input type="text"
                                   name="content[menu][{{ $i }}][link]"
                                   class="form-control"
                                   value="{{ old("content.menu.$i.link", $item['link'] ?? '') }}"
                                   placeholder="/ atau /tentang"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                            <div class="form-text" style="font-size: 10px;">Pakai <code>/</code> untuk link internal</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" style="font-size: 11px;">Icon (opsional)</label>
                            <input type="text"
                                   name="content[menu][{{ $i }}][icon]"
                                   class="form-control"
                                   value="{{ old("content.menu.$i.icon", $item['icon'] ?? '') }}"
                                   placeholder="bi-house-fill"
                                   {{ $canUpdate ? '' : 'readonly' }}>
                        </div>

                        <div class="col-12">
                            <input type="hidden" name="content[menu][{{ $i }}][is_active]" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="content[menu][{{ $i }}][is_active]"
                                       value="1"
                                       id="navbar_menu_active_{{ $i }}"
                                       @checked(old("content.menu.$i.is_active", $item['is_active'] ?? true) == 1)
                                       {{ $canUpdate ? '' : 'disabled' }}>
                                <label class="form-check-label" for="navbar_menu_active_{{ $i }}" style="font-size: 12px;">
                                    Tampilkan menu ini
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

        @if ($canUpdate)
            <button type="button" class="btn-himapro btn-himapro-secondary" onclick="addNavbarMenu()">
                <i class="bi bi-plus-lg"></i>
                Tambah Menu
            </button>
        @endif
    </div>


    {{-- CTA BUTTON --}}
    <div class="col-12" style="border-top: 1px solid var(--border); padding-top: 24px;">
        <div class="form-section-title">Tombol CTA (Kanan)</div>
    </div>

    <div class="col-12">
        <input type="hidden" name="content[cta_show]" value="0">
        <div class="form-check form-switch mb-3">
            <input class="form-check-input"
                   type="checkbox"
                   name="content[cta_show]"
                   value="1"
                   id="navbar_cta_show"
                   @checked(old('content.cta_show', $c['cta_show'] ?? true) == 1)
                   {{ $canUpdate ? '' : 'disabled' }}>
            <label class="form-check-label" for="navbar_cta_show" style="font-size: 13px;">
                Tampilkan tombol CTA di navbar
            </label>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label" style="font-size: 11px;">Teks Tombol</label>
        <input type="text"
               name="content[cta_text]"
               class="form-control"
               value="{{ old('content.cta_text', $c['cta_text'] ?? '') }}"
               placeholder="Login Admin"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-4">
        <label class="form-label" style="font-size: 11px;">Link Tombol</label>
        <input type="text"
               name="content[cta_link]"
               class="form-control"
               value="{{ old('content.cta_link', $c['cta_link'] ?? '') }}"
               placeholder="/admin/login"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

    <div class="col-md-4">
        <label class="form-label" style="font-size: 11px;">Icon Tombol</label>
        <input type="text"
               name="content[cta_icon]"
               class="form-control"
               value="{{ old('content.cta_icon', $c['cta_icon'] ?? '') }}"
               placeholder="bi-box-arrow-in-right"
               {{ $canUpdate ? '' : 'readonly' }}>
    </div>

</div>


@push('scripts')
@if ($canUpdate)
<script>
function addNavbarMenu() {
    const list = document.getElementById('navbarMenuList');
    const index = list.querySelectorAll('.navbar-menu-item').length;

    const html = `
        <div class="navbar-menu-item p-3 mb-3" style="background: rgba(255,255,255,.02); border: 1px solid var(--border); border-radius: var(--radius);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div style="font-size: 11px; font-weight: 800; color: var(--primary); text-transform: uppercase;">
                    Menu <span class="navbar-menu-number">${index + 1}</span>
                </div>
                <button type="button" class="btn-icon danger" onclick="removeNavbarMenu(this)" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" style="font-size: 11px;">Label</label>
                    <input type="text" name="content[menu][${index}][label]" class="form-control" placeholder="Beranda">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size: 11px;">Link</label>
                    <input type="text" name="content[menu][${index}][link]" class="form-control" placeholder="/">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size: 11px;">Icon (opsional)</label>
                    <input type="text" name="content[menu][${index}][icon]" class="form-control" placeholder="bi-house-fill">
                </div>
                <div class="col-12">
                    <input type="hidden" name="content[menu][${index}][is_active]" value="0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="content[menu][${index}][is_active]" value="1" id="navbar_menu_active_${index}" checked>
                        <label class="form-check-label" for="navbar_menu_active_${index}" style="font-size: 12px;">
                            Tampilkan menu ini
                        </label>
                    </div>
                </div>
            </div>
        </div>
    `;

    list.insertAdjacentHTML('beforeend', html);
    renumberNavbarMenu();
}

function removeNavbarMenu(btn) {
    btn.closest('.navbar-menu-item').remove();
    renumberNavbarMenu();
}

function renumberNavbarMenu() {
    const list = document.getElementById('navbarMenuList');
    list.querySelectorAll('.navbar-menu-item').forEach((item, i) => {
        const el = item.querySelector('.navbar-menu-number');
        if (el) el.textContent = i + 1;
    });
}
</script>
@endif
@endpush
{{-- GLOBAL SEARCH — Search box di navbar admin --}}
<div class="admin-search" id="adminSearch" data-search-url="{{ route('admin.search') }}">

    {{-- TRIGGER (kotak search) --}}
    <button type="button" class="admin-search-trigger" id="adminSearchTrigger">
        <i class="bi bi-search"></i>
        <span class="admin-search-placeholder">Cari...</span>
        <kbd class="admin-search-kbd">
            <span class="d-none d-md-inline">Ctrl</span> K
        </kbd>
    </button>


    {{-- MODAL --}}
    <div class="admin-search-modal" id="adminSearchModal">

        <div class="admin-search-backdrop" onclick="closeAdminSearch()"></div>

        <div class="admin-search-panel">

            {{-- INPUT --}}
            <div class="admin-search-input-wrap">
                <i class="bi bi-search admin-search-input-icon"></i>
                <input
                    type="text"
                    id="adminSearchInput"
                    class="admin-search-input"
                    placeholder="Cari pengurus, program kerja, agenda..."
                    autocomplete="off"
                >
                <button type="button" class="admin-search-close" onclick="closeAdminSearch()">
                    <kbd>ESC</kbd>
                </button>
            </div>

            {{-- RESULTS --}}
            <div class="admin-search-results" id="adminSearchResults">
                <div class="admin-search-empty">
                    <i class="bi bi-lightbulb"></i>
                    <div>
                        <div style="font-weight: 700; margin-bottom: 4px;">Mulai mencari</div>
                        <div style="font-size: 12px; color: var(--muted);">
                            Ketik minimal 2 karakter untuk mulai mencari.
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="admin-search-footer">
                <div class="admin-search-hint">
                    <kbd>↑↓</kbd> Navigasi
                </div>
                <div class="admin-search-hint">
                    <kbd>Enter</kbd> Buka
                </div>
                <div class="admin-search-hint">
                    <kbd>ESC</kbd> Tutup
                </div>
            </div>

        </div>

    </div>

</div>
@php
    $featured = $featured ?? false;
@endphp

<a href="{{ route('frontend.struktur.detail', $pengurus) }}" class="fe-pengurus-card {{ $featured ? 'featured' : '' }}">

    <div class="fe-pengurus-photo">
        @if ($pengurus->foto)
            <img src="{{ asset('storage/' . $pengurus->foto) }}" alt="{{ $pengurus->nama }}">
        @else
            <div class="fe-pengurus-initials">
                {{ strtoupper(substr($pengurus->nama, 0, 1)) }}
            </div>
        @endif
    </div>

    <div class="fe-pengurus-body">
        <h3 class="fe-pengurus-name">{{ $pengurus->nama }}</h3>
        <div class="fe-pengurus-role">{{ $pengurus->jabatan }}</div>

        {{-- ✅ BADGES — BPH + DEPARTEMEN --}}
        @if ($pengurus->is_bph || $pengurus->departemen)
            <div style="display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; margin-top: 4px;">

                {{-- BADGE BPH — Gold --}}
                @if ($pengurus->is_bph)
                    <span class="fe-pengurus-dept" style="
                        background: rgba(255, 210, 26, 0.12);
                        border-color: rgba(255, 210, 26, 0.4);
                        color: var(--fe-primary);
                    ">
                        <span class="dot" style="background: var(--fe-primary); box-shadow: 0 0 8px var(--fe-primary);"></span>
                        BPH
                    </span>
                @endif

                {{-- BADGE DEPARTEMEN — warna dept --}}
                @if ($pengurus->departemen)
                    <span class="fe-pengurus-dept">
                        <span class="dot" style="background: {{ $pengurus->departemen->warna ?: 'var(--fe-primary)' }};"></span>
                        {{ $pengurus->departemen->nama }}
                    </span>
                @endif

            </div>
        @endif
    </div>

</a>
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

        @if ($pengurus->departemen)
            <div class="fe-pengurus-dept">
                <span class="dot" style="background: {{ $pengurus->departemen->warna ?: 'var(--fe-primary)' }};"></span>
                {{ $pengurus->departemen->nama }}
            </div>
        @endif
    </div>

</a>
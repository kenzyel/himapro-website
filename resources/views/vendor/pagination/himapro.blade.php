@if ($paginator->hasPages())
    <div class="pagination-wrapper">

        {{-- INFO --}}
        <div class="pagination-info">
            Menampilkan
            <strong>{{ $paginator->firstItem() }}</strong>–<strong>{{ $paginator->lastItem() }}</strong>
            dari
            <strong>{{ $paginator->total() }}</strong>
        </div>

        {{-- TOMBOL --}}
        <ul class="pagination">

            {{-- PREV --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&lsaquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
            @endif

            {{-- PAGES --}}
            @foreach ($elements as $element)

                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif

            @endforeach

            {{-- NEXT --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
            @else
                <li class="disabled"><span>&rsaquo;</span></li>
            @endif

        </ul>

    </div>
@endif
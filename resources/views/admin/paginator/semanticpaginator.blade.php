@if ($paginator->hasPages())
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <a class="disabled icon item"> <i class="left chevron icon"></i></a>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="icon item"><i class="left chevron icon"></i></a>
            <!-- <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">← Previous</a></li> -->
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a class="disabled icon item">{{ $element }}</a>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="active item">{{ $page }}</a>
                    @else
                        <a class="item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="icon item">
                                    <i class="right chevron icon"></i>
        </a>
            <!-- <a href="{{ $paginator->nextPageUrl() }}" rel="next"></a> -->
        @else
            <a class="disabled icon item"> <i class="right chevron icon"></i></a>
        @endif
@endif


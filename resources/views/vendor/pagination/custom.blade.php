@if ($paginator->hasPages())
    <nav class="pagination">
        <ul class="pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="pagination-link pagination-link-prev-icon" aria-hidden="true">
                        <i data-feather="chevron-left" width="1em" height="1em"></i>
                    </span>
                </li>
            @else
                <li class="pagination-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link pagination-link-prev-icon" rel="prev" aria-label="@lang('pagination.previous')">
                        <i data-feather="chevron-left" width="1em" height="1em"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="pagination-item disabled" aria-disabled="true">
                        <span class="pagination-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination-item active" aria-current="page">
                                <span class="pagination-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="pagination-item">
                                <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link pagination-link-next-icon" rel="next" aria-label="@lang('pagination.next')">
                        <i data-feather="chevron-right" width="1em" height="1em"></i>
                    </a>
                </li>
            @else
                <li class="pagination-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="pagination-link pagination-link-next-icon" aria-hidden="true">
                        <i data-feather="chevron-right" width="1em" height="1em"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

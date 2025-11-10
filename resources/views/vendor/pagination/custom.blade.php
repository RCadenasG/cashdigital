@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center flex-row align-items-center"
            style="flex-wrap: nowrap; gap: 0.5rem; margin-bottom: 0;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" style="display: inline;">
                    <span class="page-link bg-secondary text-white border-0 px-4 py-2 rounded-start"
                        style="min-width: 90px; text-align: center;">Anterior</span>
                </li>
            @else
                <li class="page-item" style="display: inline;">
                    <a class="page-link bg-success text-white border-0 px-4 py-2 rounded-start"
                        style="min-width: 90px; text-align: center;" href="{{ $paginator->previousPageUrl() }}"
                        rel="prev">Anterior</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" style="display: inline;">
                        <span class="page-link bg-dark text-white border-0 px-3">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page" style="display: inline;">
                                <span class="page-link border-0 px-4 py-2"
                                    style="font-weight: bold; background-color: #ffc107 !important; color: #000 !important;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item" style="display: inline;">
                                <a class="page-link bg-primary text-white border-0 px-4 py-2"
                                    href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item" style="display: inline;">
                    <a class="page-link bg-success text-white border-0 px-4 py-2 rounded-end"
                        style="min-width: 90px; text-align: center;" href="{{ $paginator->nextPageUrl() }}"
                        rel="next">Siguiente</a>
                </li>
            @else
                <li class="page-item disabled" style="display: inline;">
                    <span class="page-link bg-secondary text-white border-0 px-4 py-2 rounded-end"
                        style="min-width: 90px; text-align: center;">Siguiente</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

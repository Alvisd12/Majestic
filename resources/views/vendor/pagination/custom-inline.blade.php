@if ($paginator->hasPages())
    <style>
        .custom-pagination-link:hover {
            background: var(--primary-color) !important;
            color: white !important;
            border-color: var(--primary-color) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3) !important;
        }
    </style>
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" style="display: flex; justify-content: center; align-items: center;">
        <ul class="pagination" style="display: flex; flex-direction: row; align-items: center; justify-content: center; flex-wrap: nowrap; gap: 8px; margin: 0; padding: 0; list-style: none;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" style="display: inline-flex; margin: 0; list-style: none;">
                    <span class="page-link" style="border: 1px solid var(--gray-200); color: var(--gray-400); padding: 12px 16px; border-radius: 8px; background: var(--gray-100); cursor: not-allowed; min-width: 44px; text-align: center; display: flex; align-items: center; justify-content: center;">‹</span>
                </li>
            @else
                <li class="page-item" style="display: inline-flex; margin: 0; list-style: none;">
                    <a class="page-link custom-pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="border: 1px solid var(--gray-300); color: var(--gray-700); padding: 12px 16px; border-radius: 8px; font-weight: 500; text-decoration: none; transition: all 0.2s ease; background: white; min-width: 44px; text-align: center; display: flex; align-items: center; justify-content: center;">‹</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" style="display: inline-flex; margin: 0; list-style: none;">
                        <span class="page-link" style="border: 1px solid var(--gray-200); color: var(--gray-400); padding: 12px 16px; border-radius: 8px; background: var(--gray-100); cursor: not-allowed; min-width: 44px; text-align: center; display: flex; align-items: center; justify-content: center;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" style="display: inline-flex; margin: 0; list-style: none;">
                                <span class="page-link" style="background: var(--primary-color); border-color: var(--primary-color); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); padding: 12px 16px; border-radius: 8px; font-weight: 500; min-width: 44px; text-align: center; display: flex; align-items: center; justify-content: center;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item" style="display: inline-flex; margin: 0; list-style: none;">
                                <a class="page-link custom-pagination-link" href="{{ $url }}" style="border: 1px solid var(--gray-300); color: var(--gray-700); padding: 12px 16px; border-radius: 8px; font-weight: 500; text-decoration: none; transition: all 0.2s ease; background: white; min-width: 44px; text-align: center; display: flex; align-items: center; justify-content: center;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item" style="display: inline-flex; margin: 0; list-style: none;">
                    <a class="page-link custom-pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="border: 1px solid var(--gray-300); color: var(--gray-700); padding: 12px 16px; border-radius: 8px; font-weight: 500; text-decoration: none; transition: all 0.2s ease; background: white; min-width: 44px; text-align: center; display: flex; align-items: center; justify-content: center;">›</a>
                </li>
            @else
                <li class="page-item disabled" style="display: inline-flex; margin: 0; list-style: none;">
                    <span class="page-link" style="border: 1px solid var(--gray-200); color: var(--gray-400); padding: 12px 16px; border-radius: 8px; background: var(--gray-100); cursor: not-allowed; min-width: 44px; text-align: center; display: flex; align-items: center; justify-content: center;">›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

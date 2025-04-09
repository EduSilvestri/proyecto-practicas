@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-8">
        <div class="flex space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-item disabled pagination-arrow">
                    &laquo;
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" wire:navigate
                   class="pagination-item pagination-arrow hover:bg-gray-700 hover:text-white">
                    &laquo;
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="pagination-item disabled">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-item active bg-purple-600 text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" wire:navigate
                               class="pagination-item hover:bg-gray-700 hover:text-white">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" wire:navigate
                   class="pagination-item pagination-arrow hover:bg-gray-700 hover:text-white">
                    &raquo;
                </a>
            @else
                <span class="pagination-item disabled pagination-arrow">
                    &raquo;
                </span>
            @endif
        </div>
    </nav>
@endif

<style>
    .pagination-item {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        min-width: 40px;
        text-align: center;
        background: rgba(68, 71, 90, 0.5);
        color: #f8f8f2;
        border: 1px solid rgba(98, 114, 164, 0.3);
    }
    .pagination-item:hover:not(.disabled):not(.active) {
        background: rgba(98, 114, 164, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(98, 114, 164, 0.2);
    }
    .pagination-item.active {
        background: #bd93f9;
        color: #282a36;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(189, 147, 249, 0.3);
    }
    .pagination-item.disabled {
        background: rgba(68, 71, 90, 0.2);
        color: rgba(248, 248, 242, 0.5);
        cursor: not-allowed;
    }
    .pagination-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
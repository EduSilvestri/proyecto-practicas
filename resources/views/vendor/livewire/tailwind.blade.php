@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-8">
        <div class="flex space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-item disabled pagination-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" wire:navigate
                   class="pagination-item pagination-arrow hover:bg-purple-500/10 hover:text-purple-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="pagination-item disabled dots">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-item active bg-gradient-to-br from-purple-500 to-blue-500 text-white shadow-lg shadow-purple-500/20">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" wire:navigate
                               class="pagination-item hover:bg-gray-700/50 hover:text-purple-300">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" wire:navigate
                   class="pagination-item pagination-arrow hover:bg-purple-500/10 hover:text-purple-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span class="pagination-item disabled pagination-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
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
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-width: 40px;
        text-align: center;
        background: rgba(40, 42, 54, 0.7);
        color: #f8f8f2;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .pagination-item:hover:not(.disabled):not(.active) {
        background: rgba(80, 250, 123, 0.1);
        color: #50fa7b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(80, 250, 123, 0.1);
        border-color: rgba(80, 250, 123, 0.3);
    }
    
    .pagination-item.active {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.9) 0%, rgba(59, 130, 246, 0.9) 100%);
        color: white;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
        border: none;
    }
    
    .pagination-item.disabled {
        background: rgba(30, 32, 42, 0.5);
        color: rgba(248, 248, 242, 0.3);
        cursor: not-allowed;
        border-color: rgba(68, 71, 90, 0.2);
    }
    
    .pagination-item.dots {
        background: transparent;
        border: none;
    }
    
    .pagination-arrow {
        padding: 0.5rem;
    }
    
    .pagination-arrow svg {
        stroke: currentColor;
    }
</style>
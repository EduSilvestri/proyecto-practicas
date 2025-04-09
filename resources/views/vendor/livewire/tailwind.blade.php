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

<div>
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-8">
        <div class="flex space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 bg-lujoNeg bg-opacity-50 text-lujoYel rounded-lg cursor-not-allowed">
                    &laquo;
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" wire:navigate
                   class="px-4 py-2 bg-lujoNeg text-lujoYel rounded-lg hover:bg-lujoYel hover:text-lujoNeg transition">
                    &laquo;
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-4 py-2 bg-lujoNeg text-lujoYel rounded-lg">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 bg-lujoYel text-lujoNeg font-bold rounded-lg">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" wire:navigate
                               class="px-4 py-2 bg-lujoNeg text-lujoYel rounded-lg hover:bg-lujoYel hover:text-lujoNeg transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" wire:navigate
                   class="px-4 py-2 bg-lujoNeg text-lujoYel rounded-lg hover:bg-lujoYel hover:text-lujoNeg transition">
                    &raquo;
                </a>
            @else
                <span class="px-4 py-2 bg-lujoNeg bg-opacity-50 text-lujoYel rounded-lg cursor-not-allowed">
                    &raquo;
                </span>
            @endif
        </div>
    </nav>
@endif
</div>

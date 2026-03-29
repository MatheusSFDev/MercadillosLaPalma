@php
if (! isset($scrollTo)) {
    $scrollTo = false;
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">

            {{-- Mobile: solo anterior/siguiente --}}
            <div class="flex justify-between flex-1 sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-accent-grey bg-status-white border border-accent-lightgrey cursor-default leading-5 rounded-lg font-dm-serif">
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-status-dark bg-status-white border border-accent-lightgrey leading-5 rounded-lg hover:bg-accent-lightred transition-colors font-dm-serif">
                            {!! __('pagination.previous') !!}
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-status-dark bg-status-white border border-accent-lightgrey leading-5 rounded-lg hover:bg-accent-lightred transition-colors font-dm-serif">
                            {!! __('pagination.next') !!}
                        </button>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-accent-grey bg-status-white border border-accent-lightgrey cursor-default leading-5 rounded-lg font-dm-serif">
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>

            {{-- Desktop: texto de resultados + botones de página --}}
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">

                {{-- Texto "Mostrando del X al Y de Z resultados" --}}
                <div>
                    <p class="text-sm text-coffee-light leading-5 font-dm-serif">
                        <span>Mostrando del </span>
                        <span class="font-semibold text-status-dark">{{ $paginator->firstItem() }}</span>
                        <span>al</span>
                        <span class="font-semibold text-status-dark">{{ $paginator->lastItem() }}</span>
                        <span>de</span>
                        <span class="font-semibold text-status-dark">{{ $paginator->total() }}</span>
                        <span>resultados</span>
                    </p>
                </div>

                {{-- Botones de paginación --}}
                <div>
                    <span class="relative z-0 inline-flex rtl:flex-row-reverse rounded-lg shadow-sm gap-1">

                {{-- Botón anterior --}}
                <button
                    type="button"
                    wire:click="previousPage('{{ $paginator->getPageName() }}')"
                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                    @if ($paginator->onFirstPage()) disabled @endif
                    aria-label="{{ __('pagination.previous') }}"
                    class="relative inline-flex items-center justify-center px-2 py-2 text-sm font-medium border rounded-lg leading-5
                        {{ $paginator->onFirstPage()
                            ? 'text-accent-grey bg-status-white border-accent-lightgrey cursor-default'
                            : 'text-status-dark bg-status-white border-accent-lightgrey hover:bg-accent-lightred transition-colors'
                        }}"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>

                {{-- Números de página --}}
                @foreach ($elements as $element)

                    {{-- Separador "..." --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span class="relative inline-flex items-center px-6 py-2 text-sm font-medium text-accent-grey bg-status-white border border-accent-lightgrey cursor-default leading-5 rounded-lg font-dm-serif">
                                {{ $element }}
                            </span>
                        </span>
                    @endif

                    {{-- Links de página --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">

                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center justify-center px-6 py-2 text-sm font-bold text-status-white bg-accent-olive border border-accent-olive leading-5 rounded-lg font-dm-serif">
                                            {{ $page }}
                                        </span>
                                    </span>
                                @else
                                    <button
                                        type="button"
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                        aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                        class="relative inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-status-dark bg-status-white border border-accent-lightgrey leading-5 rounded-lg hover:bg-accent-lightred transition-colors font-dm-serif"
                                    >
                                        {{ $page }}
                                    </button>
                                @endif

                            </span>
                        @endforeach
                    @endif

                @endforeach

                {{-- Botón siguiente --}}
                <button
                    type="button"
                    wire:click="nextPage('{{ $paginator->getPageName() }}')"
                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                    @if (!$paginator->hasMorePages()) disabled @endif
                    aria-label="{{ __('pagination.next') }}"
                    class="relative inline-flex items-center justify-center px-2 py-2 text-sm font-medium border rounded-lg leading-5
                        {{ !$paginator->hasMorePages()
                            ? 'text-accent-grey bg-status-white border-accent-lightgrey cursor-default'
                            : 'text-status-dark bg-status-white border-accent-lightgrey hover:bg-accent-lightred transition-colors'
                        }}"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>

                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
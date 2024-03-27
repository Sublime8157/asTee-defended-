@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        <div>
            <p class="text-xs text-gray-700 leading-5">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-medium">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>
        <div class="flex items-center">
        {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-2 py-1 text-sm font-medium text-gray-500 bg-white border  cursor-default leading-5 ">
                        <span class="flex items-center">
                            <ion-icon name="chevron-back-outline" class="text-xs"></ion-icon>
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-white border leading-5  hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300  active:text-gray-700 transition ease-in-out duration-150">
                        <span class="flex items-center"><ion-icon name="chevron-back-outline" class="text-xs"></ion-icon></span>
                    </a>
                @endif
                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-2  -ml-px text-xs font-medium border border-gray-300 bg-blue-400  text-white cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-2  -ml-px text-xs font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5  hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        <ion-icon name="chevron-forward-outline" class="text-xs"></ion-icon>
                    </a>
                @else
                    <span class="relative inline-flex items-center px-2 py-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 ">
                       <ion-icon name="chevron-forward-outline" class="text-xs"></ion-icon>
                    </span>
                @endif
        </div>
    </nav>
@endif

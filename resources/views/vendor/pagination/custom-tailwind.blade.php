{{-- resources/views/vendor/pagination/custom-tailwind.blade.php --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col gap-4 items-center justify-center py-6">
        <div class="flex justify-between flex-1 w-full sm:hidden gap-2">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#7a4025] rounded-lg shadow-lg cursor-default leading-5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#7a4025] rounded-lg shadow-lg hover:bg-[#63321c] focus:outline-none focus:ring ring-[#7a4025] focus:border-[#7a4025] transition ease-in-out duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    Prev
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center gap-2 px-4 py-2 ml-3 text-sm font-medium text-white bg-[#7a4025] rounded-lg shadow-lg hover:bg-[#63321c] focus:outline-none focus:ring ring-[#7a4025] focus:border-[#7a4025] transition ease-in-out duration-150">
                    Next
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="relative inline-flex items-center gap-2 px-4 py-2 ml-3 text-sm font-medium text-white bg-[#7a4025] rounded-lg shadow-lg cursor-default leading-5">
                    Next
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center w-full gap-6">
            <div class="flex items-center justify-center">
                <p class="text-sm text-gray-700 leading-5 dark:text-gray-400 px-4 py-2 bg-white rounded shadow border border-gray-200">
                    Showing
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    of
                    <span class="font-medium">{{ $paginator->total() }}</span>
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-lg rounded-lg gap-0.5">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Prev">
                            <span class="relative inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#7a4025] rounded-l-lg shadow-lg cursor-default leading-5" aria-hidden="true">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                Prev
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#7a4025] rounded-l-lg shadow-lg hover:bg-[#63321c] focus:z-10 focus:outline-none focus:ring ring-[#7a4025] focus:border-[#7a4025] transition ease-in-out duration-150" aria-label="Prev">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            Prev
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-[#7a4025] bg-white border border-gray-300 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-[#7a4025] rounded shadow-lg cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-[#7a4025] bg-white border border-gray-300 rounded shadow-lg hover:bg-[#7a4025] hover:text-white focus:z-10 focus:outline-none focus:ring ring-[#7a4025] focus:border-[#7a4025] transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center gap-2 px-4 py-2 -ml-px text-sm font-medium text-white bg-[#7a4025] rounded-r-lg shadow-lg hover:bg-[#63321c] focus:z-10 focus:outline-none focus:ring ring-[#7a4025] focus:border-[#7a4025] transition ease-in-out duration-150" aria-label="Next">
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Next">
                            <span class="relative inline-flex items-center gap-2 px-4 py-2 -ml-px text-sm font-medium text-white bg-[#7a4025] rounded-r-lg shadow-lg cursor-default leading-5" aria-hidden="true">
                                Next
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif

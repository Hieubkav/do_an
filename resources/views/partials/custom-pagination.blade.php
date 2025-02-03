@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center ">
        
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                <
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                <
            </a>
        @endif

        {{-- Pagination Elements --}}
        @php
            $totalPages = $paginator->lastPage();
            $current = $paginator->currentPage();
        @endphp

        {{-- Always show first two pages --}}
        @for ($i = 1; $i <= 2; $i++)
            <a href="{{ $paginator->url($i) }}" class="{{ $i == $current ? 'text-white bg-blue-500' : 'text-gray-700 bg-white' }} relative inline-flex items-center px-3 py-2 text-sm font-medium border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                {{ $i }}
            </a>
        @endfor

        {{-- "..." after first two pages if needed --}}
        @if ($current > 5)
            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                ...
            </span>
        @endif

        {{-- Window around current page --}}
        @php
            $start = max(3, $current - 1);
            $end = min($current + 1, $totalPages - 2);
        @endphp
        @for ($i = $start; $i <= $end; $i++)
            <a href="{{ $paginator->url($i) }}" class="{{ $i == $current ? 'text-white bg-blue-500' : 'text-gray-700 bg-white' }} relative inline-flex items-center px-3 py-2 text-sm font-medium border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                {{ $i }}
            </a>
        @endfor

        {{-- "..." before last two pages if needed --}}
        @if ($current < $totalPages - 4)
            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                ...
            </span>
        @endif

        {{-- Always show last two pages --}}
        @for ($i = $totalPages - 1; $i <= $totalPages; $i++)
            <a href="{{ $paginator->url($i) }}" class="{{ $i == $current ? 'text-white bg-blue-500' : 'text-gray-700 bg-white' }} relative inline-flex items-center px-3 py-2 text-sm font-medium border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                {{ $i }}
            </a>
        @endfor

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                >
            </a>
        @else
            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                >
            </span>
        @endif

    </nav>
@endif

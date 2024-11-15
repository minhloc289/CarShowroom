@if ($paginator->hasPages())
    <div class="d-flex flex-wrap py-2 mr-3">
        {{-- Hiển thị thông tin --}}
        <div class="d-flex align-items-center py-3">
            <span class="text-muted">
                Showing {{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }} 
                to {{ min($paginator->currentPage() * $paginator->perPage(), $paginator->total()) }} 
                of {{ $paginator->total() }}
            </span>
            <span class="text-muted ms-2">results</span>
        </div>

        {{-- Nút phân trang --}}
        <div class="d-flex ms-3">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="btn btn-icon btn-sm btn-light btn-active-light-primary me-2" disabled>
                    <span class="svg-icon svg-icon-2 me-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5 19L8.5 12L15.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-icon btn-sm btn-light btn-active-light-primary me-2">
                    <span class="svg-icon svg-icon-2 me-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5 19L8.5 12L15.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="btn btn-icon btn-sm border-0 btn-primary me-2">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}" class="btn btn-icon btn-sm btn-light btn-active-light-primary me-2">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-icon btn-sm btn-light btn-active-light-primary me-2">
                    <span class="svg-icon svg-icon-2 me-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.5 19L15.5 12L8.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            @else
                <button class="btn btn-icon btn-sm btn-light btn-active-light-primary me-2" disabled>
                    <span class="svg-icon svg-icon-2 me-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.5 19L15.5 12L8.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </button>
            @endif
        </div>
    </div>
@endif
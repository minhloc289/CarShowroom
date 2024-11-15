@unless ($breadcrumbs->isEmpty())
<div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
        {{ $breadcrumbs->first()->title }}
    </h1>
    <span class="test h-20px border-gray-200 border-start mx-4"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        @foreach ($breadcrumbs->slice(1) as $breadcrumb)
            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li class="breadcrumb-item text-muted">
                    <a href="{{ $breadcrumb->url }}" class="text-muted text-hover-primary">
                        {{ $breadcrumb->title }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
            @else
                <li class="breadcrumb-item text-dark">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ul>
</div>
@endunless
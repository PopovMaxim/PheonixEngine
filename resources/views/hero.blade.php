<div class="bg-body-light">
    <div class="content content-boxed mb-4">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">{!! $title ?? '' !!}</h1>
            @if ($breadcrumbs)
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item @if (isset($breadcrumb['active'])) active @endif" @if (isset($breadcrumb['active'])) aria-current="page @endif">
                                @if (isset($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}">
                                @endif
                                {{ $breadcrumb['title'] }}
                                @if (isset($breadcrumb['url']))
                                </a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif
        </div>
    </div>
</div>
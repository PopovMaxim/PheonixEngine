@extends('faq::layouts.master')

@push('js')
    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <!-- <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
@endpush

@push('css')
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="bg-body-light">
        <div class="content content-boxed">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center pb-4">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">FAQ</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">База знаний</li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content content-boxed">
        <div class="block block-rounded">
            <div class="block-content">
                @foreach ($categories as $category)
                    <h2 class="content-heading"><strong>{{ $loop->index+1 }}.</strong> {{ $category['title'] }}</h2>
                    <div class="row items-push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                                {{ $category['description'] }}
                            </p>
                        </div>
                        <div class="col-lg-8">
                            <div id="faq{{ $category['id'] }}" role="tablist" aria-multiselectable="true">
                                @forelse ($category->items()->orderBy('order', 'asc')->get() as $item)
                                    <div class="block block-rounded mb-1">
                                        <div class="block-header block-header-default" role="tab" id="faq{{ $category['id'] }}_h{{ $item['id'] }}">
                                            <a class="fw-semibold collapsed" data-bs-toggle="collapse" data-bs-parent="#faq{{ $category['id'] }}" href="#faq{{ $category['id'] }}_q{{ $item['id'] }}" aria-expanded="false" aria-controls="faq{{ $category['id'] }}_q{{ $item['id'] }}">{!! $item['question'] !!}</a>
                                        </div>
                                        <div id="faq{{ $category['id'] }}_q{{ $item['id'] }}" class="collapse" role="tabpanel" aria-labelledby="faq{{ $category['id'] }}_h{{ $item['id'] }}" data-bs-parent="#faq{{ $category['id'] }}" style="">
                                            <div class="block-content">
                                                <p>{!! $item['answer'] !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@extends('robots::layouts.master')

@section('content')
    @include('hero', ['title' => "Дистрибутивы", 'breadcrumbs' => $breadcrumbs])

    <div class="content content-boxed">
        <div class="row items-push">
            
            @foreach (\App\Modules\Tariffs\Entities\TariffLines::query()->orderBy('order', 'asc')->where('details->status', 1)->get() as $line)
                <div class="col-md-4">
                    <div class="block block-rounded h-100 mb-0">
                        <div class="block-content bg-body-light text-center py-5">
                            <h3 class="fs-4 fw-bold mb-1">
                                <b>{{ $line['title'] }}</b>
                            </h3>
                            <h4 class="fs-6 text-muted mb-0">Актуальная версия: 1.08</h4>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row g-sm">
                                <div class="col">
                                    <form method="post" action="{{ route('distribution.download', ['id' => $line['id']]) }}">
                                        @csrf
                                        <button class="btn w-100 btn-alt-secondary">
                                            <i class="fa fa-download me-1 opacity-50"></i> Скачать
                                        </button>
                                    </form>
                                </div>
                                {{--<div class="col-6">
                                    <a class="btn w-100 btn-alt-secondary" href="{{ route('distribution.archive', ['id' => $line['id']]) }}">
                                        <i class="fa fa-archive me-1 opacity-50"></i> Архив
                                    </a>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

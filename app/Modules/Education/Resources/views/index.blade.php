@extends('education::layouts.master')

@section('content')
@include('hero', ['title' => "Обучение", 'breadcrumbs' => $breadcrumbs])
<div class="content content-boxed">
    <!-- Lessons -->
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <table class="table table-striped table-borderless table-vcenter">
                <tbody>
                    @foreach ($videos as $key => $video)
                        <tr>
                            <td class="text-center w-25 d-none d-md-table-cell">
                                @if (!$video['closed'])
                                    <a class="item item-circle bg-primary text-white fs-2 mx-auto" href="{{ route('education.read', ['id' => $id, 'number' => $key]) }}">
                                        {{ $video['number'] }}
                                    </a>
                                @else
                                    <a class="item item-circle bg-primary text-white fs-2 mx-auto" data-bs-toggle="tooltip" title="Чтобы посмотреть это видео, сначала посмотрите до конца все предыдущие.">
                                        <i class="fa fa-lock"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                <div class="py-4">
                                    <div class="fs-sm fw-bold text-uppercase mb-2">
                                        <span class="text-muted me-3">Эпизод {{ $video['number'] }}</span>
                                        <span class="text-primary">
                                            <i class="fa fa-clock"></i> {{ $video['time'] }}
                                        </span>
                                    </div>
                                    @if (!$video['closed'])
                                        <a class="h4 mb-2 d-inline-block text-dark" href="{{ route('education.read', ['id' => $id, 'number' => $key]) }}">
                                            {{ $video['title'] }}
                                        </a>
                                    @else
                                        <a class="h4 mb-2 d-inline-block text-dark">
                                            {{ $video['title'] }}
                                        </a>
                                    @endif
                                    <p class="text-muted mb-0">
                                        {{ $video['description'] }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Lessons -->
</div>
@endsection

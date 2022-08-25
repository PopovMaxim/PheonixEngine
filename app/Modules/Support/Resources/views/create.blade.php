@extends('support::layouts.master')

@section('content')
    <div class="bg-transparent">
        <div class="content content-full content-top">
            <div class="py-4 text-center">
                <h1 class="fw-bold">
                    Запрос в поддержку
                </h1>
                <a class="btn btn-hero btn-secondary" href="{{ route('support') }}">
                    <i class="fa fa-arrow-left me-1"></i> К списку запросов
                </a>
            </div>
        </div>
    </div>
    <div class="content content-boxed">
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <div class="block">
                <div class="block-content">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <div class="my-4">
                                <label class="form-label" for="category">Категория</label>
                                <select class="form-select @error('subject_id') is-invalid @enderror" id="category" name="subject_id">
                                    <option value="" selected="">Выберите категорию вопроса</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject['id'] }}">{{ $subject['title'] }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="text">Ваш вопрос</label>
                                <textarea class="form-control @error('text') is-invalid @enderror" id="text" name="text" rows="5" placeholder="Подробно опишите ваш вопрос..."></textarea>
                                @error('text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content bg-body-light">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-alt-primary">
                                <i class="fa fa-fw fa-check opacity-50 me-1"></i> Отправить запрос
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@extends('robots::layouts.master')

@section('content')
    @livewire('tariffs', [
        'line' => $line['id']
    ])
    <div class="d-flex justify-content-center my-5">
        <div class="text-center text-muted">Чтобы Вам было начислено вознаграждение за рекомендацию <br/> Вы должны иметь действующую лицензию на продукт данной линейки.</div>
    </div>
@endsection

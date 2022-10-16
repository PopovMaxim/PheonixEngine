@extends('robots::layouts.master')

@section('content')
    @livewire('tariffs', [
        'line' => $line['id']
    ])
    <div class="d-flex justify-content-center my-5">
        <div class="text-center text-muted">Чтобы вам было начислено вознаграждению за рекомендацию <br/> Вы должны иметь действующую лицензию на продукт.</div>
    </div>
@endsection

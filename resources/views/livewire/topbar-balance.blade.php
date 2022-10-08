<div class="d-inline-block">
    <a href="{{ route('transfer') }}" class="btn btn-alt-secondary">
        <i class="fa fa-fw fa-coins fs-sm"></i>
        <span class="fs-sm">{{ request()->user()->formatted_balance }}</span>
    </a>
</div>
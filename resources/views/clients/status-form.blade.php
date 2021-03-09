@can('update', $model)
<form method="POST" class="d-inline" action="{{ route('clients.update_status', $model) }}">
    @method('PATCH')
    @csrf
    <input type="hidden" name="is_active" value="{{ $model->is_active ? 0 : 1 }}">
    <a href="" class="formSubmit font-weight-bold {{ $model->is_active ? 'text-success' : 'text-danger' }}" data-rel="tooltip" title="{{ $model->is_active ? 'Set Inactive' : 'Set Active' }}"><i class="href fas fa-power-off {{ isset($iconClass) ? $iconClass : '' }}"></i>@isset($text) {{ $model->is_active ? 'Active' : 'Inactive' }} @endif</a>
</form>
@else
<a class="font-weight-bold text-{{ $model->is_active ? 'success' : 'danger' }}" data-rel="tooltip" title="{{ $model->is_active ? 'Active' : 'Inactive' }}"><i class="fas fa-power-off {{ isset($iconClass) ? $iconClass : '' }}"></i> @isset($text) {{ $model->is_active ? 'Active' : 'Inactive' }} @endif </a>
@endcan

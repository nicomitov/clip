@extends('layouts.app')

@section('page_title', 'Users')

@section('page_buttons')
    @can('create', 'App\User')
    <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-user-plus"></i> Add New
    </a>
    @endcan
@endsection

@section('content')

    <table class="table table-striped table-sm" id="dTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Department</th>
                <th>E-Mail</th>
                <th>Roles</th>
                <th class="text-right">Created</th>
                <th class="text-right">Updated</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->department }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ implode_nm($user->roles, 'name') }}</td>
                <td class="text-right">
                    <span data-rel="tooltip" title="{{  $user->created_at }}">{{ $user->created_at->format('j M Y') }}</span>
                </td>
                <td class="text-right">
                    <span data-rel="tooltip" title="{{  $user->updated_at }}">{{ $user->updated_at->format('j M Y') }}</span>
                </td>
                <td class="text-right text-nowrap">
                    {{-- status --}}
                    @can('update', $user)
                    <form method="POST" class="d-inline" action="{{ route('users.update_status', $user) }}">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                        <a href="" class="formSubmit {{ $user->is_active ? 'text-success' : 'text-danger' }}" data-rel="tooltip" title="{{ $user->is_active ? 'Set Inactive' : 'Set Active' }}"><i class="fas fa-power-off fa-fw fa-lg"></i></a>
                    </form>
                    @endcan

                    {{-- edit --}}
                    @can('update', $user)
                    <a href="{{ route('users.edit', $user) }}" class="icon-edit ml-2" data-rel="tooltip" title="Edit User"><i class="far fa-edit fa-fw fa-lg"></i></a>
                    @endcan

                    {{-- delete --}}
                    @can('delete', $user)
                    <form method="POST" class="d-inline form-delete" action="{{ route('users.destroy', $user) }}">
                        @method('DELETE')
                        @csrf
                        <a href="" class="icon-delete ml-2" data-rel="tooltip" title="Delete User"><i class="far fa-trash-alt fa-fw fa-lg"></i></a>
                    </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    @include('partials.noentries', ['text' => 'No Users Found!'])
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection

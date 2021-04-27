@extends('layouts.app')

@section('page_title', 'Edit User: ' . $user->name)

@section('page_buttons')
    @can('delete', $user)
    <form method="POST" class="d-inline form-delete" action="{{ route('users.destroy', $user) }}">
        @method('DELETE')
        @csrf
        <a href="" class="btn btn-sm btn-outline-secondary">
            <i class="far fa-trash-alt"></i> Delete
        </a>
    </form>
    @endcan
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="card">
                <div class="card-header bg-white">Edit User Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @method('PATCH')
                        @csrf
                        @include('users.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

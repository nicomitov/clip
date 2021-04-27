@extends('layouts.app')

@section('page_title', 'Edit Client: ' . $client->name)

@section('page_buttons')
    @can('delete', $client)
    <form method="POST" class="d-inline form-delete" action="{{ route('clients.destroy', $client) }}">
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
                <div class="card-header bg-white">Edit Client Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clients.update', $client) }}">
                        @method('PATCH')
                        @csrf
                        @include('clients.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

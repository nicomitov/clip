@extends('layouts.app')

@section('page_title', 'Edit Topic: ' . $topic->name)

@section('page_buttons')
    @can('delete', $topic)
    <form method="POST" class="d-inline form-delete" action="{{ route('topics.destroy', $topic) }}">
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
                <div class="card-header bg-white">Edit Topic Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('topics.update', $topic) }}">
                        @method('PATCH')
                        @csrf
                        @include('topics.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

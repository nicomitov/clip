@extends('layouts.app')

@section('page_title', 'Edit Page: ' . $page->title)

@section('page_buttons')
    @can('delete', $page)
    <form method="POST" class="d-inline form-delete" action="{{ route('pages.destroy', $page) }}">
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
                <div class="card-header bg-white">Edit Page Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pages.update', $page) }}">
                        @method('PATCH')
                        @csrf
                        @include('pages.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

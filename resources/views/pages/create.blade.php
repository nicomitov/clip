@extends('layouts.app')

@section('page_title', 'New Page')

@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="card">
                <div class="card-header bg-white">Create Page Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pages.store') }}">
                        @csrf
                        @include('pages.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('page_title', 'New Topic')

@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="card">
                <div class="card-header bg-white">Create Topic Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('topics.store') }}">
                        @csrf
                        @include('topics.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

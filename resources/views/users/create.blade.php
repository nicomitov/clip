@extends('layouts.app')

@section('page_title', 'New User')

@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="card">
                <div class="card-header bg-white">Create User Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        @include('users.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

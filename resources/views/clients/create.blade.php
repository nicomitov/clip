@extends('layouts.app')

@section('page_title', 'New Client')

@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="card">
                <div class="card-header bg-white">Create Client Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clients.store') }}">
                        @csrf
                        @include('clients.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

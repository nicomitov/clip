@extends('layouts.app')

@section('page_title', 'New Subscription')

@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="card">
                <div class="card-header bg-white">Create Subscription Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('subscriptions.store') }}">
                        @csrf
                        @include('subscriptions.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('page_title', 'Edit Subscription: ' . $subscription->id)

@section('page_buttons')
    @can('delete', $subscription)
    <form method="POST" class="d-inline form-delete" action="{{ route('subscriptions.destroy', $subscription) }}">
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
                <div class="card-header bg-white">Edit Subscription Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('subscriptions.update', $subscription) }}">
                        @method('PATCH')
                        @csrf
                        @include('subscriptions.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

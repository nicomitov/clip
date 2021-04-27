@extends('layouts.app')

@section('page_title', $pageTitle ?? 'Clients')

@section('page_buttons')
    @can('create', 'App\Client')
    <a href="{{ route('clients.create') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-plus"></i> Add New
    </a>
    @endcan
@endsection

@section('content')

    <table class="table table-striped table-sm" id="dTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Subscriptions</th>
                <th class="text-right">Created</th>
                <th class="text-right">Updated</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($clients as $client)
            <tr class="clickable" data-href="{{ route('clients.show', $client) }}">
                {{-- id --}}
                <td>{{ $client->id }}</td>

                {{-- name --}}
                <td>
                    @include('clients.status-form', ['model' => $client, 'iconClass' => 'fa-fw'])
                    <span class="ml-2">{{ $client->name }}</span>
                </td>

                {{-- subscriptions --}}
                <td>
                    @forelse ($client->subscriptions as $subscription)
                        <p class="mb-0">
                            <a href="{{ route('subscriptions.show', $subscription) }}" class="mr-2"><i class="fas fa-external-link-alt"></i> {{ $subscription->type->display_name }}</a>
                            [<span class="small font-weight-bold {{ $subscription->end_date < \Carbon\Carbon::now()->toDateString() ? 'text-danger' : 'text-success' }}">
                                {{ $subscription->start_date->format('j M Y') }} -
                                {{ $subscription->end_date->format('j M Y') }}
                            </span>]
                        </p>
                    @empty
                    No Subscriptions Found!
                    @endforelse
                </td>

                {{-- created --}}
                <td class="text-right">
                    <span data-rel="tooltip" title="{{  $client->created_at }}">{{ $client->created_at->format('j M Y') }}</span>
                </td>

                {{-- updated --}}
                <td class="text-right">
                    <span data-rel="tooltip" title="{{  $client->updated_at }}">{{ $client->updated_at->format('j M Y') }}</span>
                </td>

                {{-- actions --}}
                <td class="text-right text-nowrap">
                    {{-- view --}}
                    <a href="{{ route('clients.show', $client) }}" class="icon-info" data-rel="tooltip" title="View Client"><i class="far fa-eye fa-lg"></i></a>

                    {{-- edit --}}
                    @can('update', $client)
                    <a href="{{ route('clients.edit', $client) }}" class="icon-edit ml-2" data-rel="tooltip" title="Edit Client"><i class="far fa-edit fa-fw fa-lg"></i></a>
                    @endcan

                    {{-- delete --}}
                    @can('delete', $client)
                    <form method="POST" class="d-inline form-delete" action="{{ route('clients.destroy', $client) }}">
                        @method('DELETE')
                        @csrf
                        <a href="" class="icon-delete ml-2" data-rel="tooltip" title="Delete Client"><i class="href far fa-trash-alt fa-fw fa-lg"></i></a>
                    </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    @include('partials.noentries', ['text' => 'No Clients Found!'])
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection

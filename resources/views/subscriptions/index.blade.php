@extends('layouts.app')

@section('page_title', $pageTitle ?? 'Subscriptions')

@section('page_buttons')
    @can('create', 'App\Subscription')
    <a href="{{ route('subscriptions.create') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-plus"></i> Add New
    </a>
    @endcan
@endsection

@section('content')

    <table class="table table-striped table-sm" id="dTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Type</th>
                <th>Period</th>
                <th class="text-right">Created</th>
                <th class="text-right">Updated</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($subscriptions as $subscription)
            <tr class="clickable" data-href="{{ route('subscriptions.show', $subscription) }}">
                {{-- id --}}
                <td>{{ $subscription->id }}</td>

                {{-- client --}}
                <td>
                    @include('clients.status-form', ['model' => $subscription->client, 'iconClass' => ''])
                    <span class="ml-2">{{ $subscription->client->name }}</span>
                </td>

                {{-- type --}}
                <td>
                    <p class="mb-0">{{ $subscription->type->display_name }}</p>
                    @if ($subscription->type->name == 'clip')
                        @forelse ($subscription->topics as $topic)
                            <span class="badge badge-secondary" data-rel="tooltip" title="{{ $topic->name }}">
                                {{ $topic->number }}
                            </span>
                        @empty
                            <span class="small text-danger">No topics found!</span>
                        @endforelse
                    @endif
                </td>

                {{-- period --}}
                <td class="small font-weight-bold {{ $subscription->end_date < \Carbon\Carbon::now()->toDateString() ? 'text-danger' : 'text-success' }}">
                    {{ $subscription->start_date->format('j M Y') }}
                    <br>
                    {{ $subscription->end_date->format('j M Y') }}
                </td>

                {{-- created --}}
                <td class="text-right">
                    {{ $subscription->created_at->format('j M Y') }}
                </td>

                {{-- updated --}}
                <td class="text-right">
                    {{ $subscription->updated_at->format('j M Y') }}
                </td>

                {{-- actions --}}
                <td class="text-right text-nowrap">
                    {{-- view --}}
                    <a href="{{ route('subscriptions.show', $subscription) }}" class="icon-info"  data-rel="tooltip" title="View Subscription"><i class="far fa-eye fa-fw fa-lg"></i></a>

                    {{-- edit --}}
                    @can('update', $subscription)
                    <a href="{{ route('subscriptions.edit', $subscription) }}" class="icon-edit ml-2" data-rel="tooltip" title="Edit Subscription"><i class="far fa-edit fa-fw fa-lg"></i></a>
                    @endcan

                    {{-- delete --}}
                    @can('delete', $subscription)
                    <form method="POST" class="d-inline form-delete" action="{{ route('subscriptions.destroy', $subscription) }}">
                        @method('DELETE')
                        @csrf
                        <a href="" class="ml-2 icon-delete" data-rel="tooltip" title="Delete Subscription"><i class="href far fa-trash-alt fa-fw fa-lg"></i></a>
                    </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    @include('partials.noentries', ['text' => 'No Subscriptions Found!'])
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection

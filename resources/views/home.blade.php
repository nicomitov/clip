@extends('layouts.app')

@section('page_title', 'Home')

@section('page_buttons')

@endsection

@section('content')
<div class="home">
    {{-- unread notifications --}}
    @if (auth()->user()->hasNotifications())
        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-bell fa-fw fa-lg"></i>
            You have <span class="font-weight-bold">{{ auth()->user()->unreadNotifications()->count() }}</span> unread notifications! <a href="{{ route('notifications.index') }}" class="font-weight-bold">Check them out...</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- subscription cards --}}
    <div class="wrapper">
        <div class="row">
            {{-- <div class="col-lg-12">
                <h2 class="heading">Subscription Stats</h2>
            </div> --}}

            {{-- active --}}
            <div class="col-md-6 col-xl-3">
                <a class="dashboard-stat success" href="{{ route('subscriptions.status', 'active') }}">
                    <div class="visual">
                        <i class="far fa-check-circle"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span>{{ $activeSubscriptions.' / '.$totalSubscriptions }}</span>
                        </div>
                        <div class="desc">Active Subscriptions</div>
                        <div class="progress" data-rel="tooltip" title="{{ $activeStat }}%">
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ $activeStat }}%;" aria-valuenow="{{ $activeStat }}" aria-valuemin="0" aria-valuemax="100">{{ $activeStat }}%</div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- expiring --}}
            <div class="col-md-6 col-xl-3">
                <a class="dashboard-stat warning" href="{{ route('subscriptions.status', 'inactive') }}">
                    <div class="visual">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span>{{ $expiringSubscriptions.' / '.$totalSubscriptions }}</span>
                        </div>
                        <div class="desc">Expiring within 7 days</div>
                        <div class="progress" data-rel="tooltip" title="{{ $expiringStat }}%">
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ $expiringStat }}%;" aria-valuenow="{{ $expiringStat }}" aria-valuemin="0" aria-valuemax="100">{{ $expiringStat }}%</div>
                        </div>
                    </div>
                </a>
            </div>

             {{-- dn --}}
            <div class="col-md-6 col-xl-3">
                <a class="dashboard-stat primary" href="{{ route('subscriptions.by_type', 'dn') }}">
                    <div class="visual">
                        <i class="far fa-check-circle"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span>{{ $dnSubscriptions.' / '.$activeSubscriptions }}</span>
                        </div>
                        <div class="desc">DN Subscriptions</div>
                        <div class="progress" data-rel="tooltip" title="{{ $dnStat }}%">
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ $dnStat }}%;" aria-valuenow="{{ $dnStat }}" aria-valuemin="0" aria-valuemax="100">{{ $dnStat }}%</div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- clip --}}
            <div class="col-md-6 col-xl-3">
                <a class="dashboard-stat primary" href="{{ route('subscriptions.by_type', 'clip') }}">
                    <div class="visual">
                        <i class="far fa-check-circle"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span>{{ $clipSubscriptions.' / '.$activeSubscriptions }}</span>
                        </div>
                        <div class="desc">CLIP Subscriptions</div>
                        <div class="progress" data-rel="tooltip" title="{{ $clipStat }}%">
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ $clipStat }}%;" aria-valuenow="{{ $clipStat }}" aria-valuemin="0" aria-valuemax="100">{{ $clipStat }}%</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    Last Updated Clients
                    {{-- @can('create', 'App\Client')
                    <a href="{{ route('clients.create') }}" class="btn btn-sm btn-outline-secondary float-right"><i class="fas fa-plus"></i> Add New</a>
                    @endcan --}}
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <th>Name</th>
                            <th>Emails</th>
                            <th class="text-right">Updated</th>
                        </thead>
                        <tbody>
                            @forelse ($clients as $client)
                            <tr class="clickable" data-href="{{ route('clients.show', $client) }}">
                                {{-- name --}}
                                <td>
                                    @include('clients.status-form', ['model' => $client])
                                    <span class="ml-2">{{ $client->name }}</span>
                                </td>

                                {{-- emails --}}
                                <td>{!! $client->emailList() !!}</td>

                                {{-- updated --}}
                                <td class="text-right">
                                    <span data-rel="tooltip" title="{{ $client->updated_at }}">
                                    {{ $client->updated_at->format('j M Y') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                                @include('partials.noentries', ['text' => 'No Clients Found!'])
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    Last Updated Subscriptions
                    {{-- @can('create', 'App\Subscription')
                    <a href="{{ route('clients.create') }}" class="btn btn-sm btn-outline-secondary float-right"><i class="fas fa-plus"></i> Add New</a>
                    @endcan --}}
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <th>Client</th>
                            <th>Type</th>
                            <th>Period</th>
                            <th class="text-right">Updated</th>
                        </thead>
                        <tbody>
                            @forelse ($subscriptions as $subscription)
                            <tr class="clickable" data-href="{{ route('subscriptions.show', $subscription) }}">

                                {{-- client --}}
                                <td>{{ $subscription->client->name }}</td>

                                {{-- type --}}
                                <td>
                                    {{ $subscription->type->display_name }}
                                    <div>
                                    @if ($subscription->type->name == 'clip')
                                        @forelse ($subscription->topics as $topic)
                                            <span class="badge badge-secondary" data-rel="tooltip" title="{{ $topic->name }}">
                                                {{ $topic->number }}
                                            </span>
                                        @empty
                                            <span class="small text-danger">No topics found!</span>
                                        @endforelse
                                    @endif
                                    </div>
                                </td>

                                {{-- period --}}
                                <td class="small font-weight-bold {{ $subscription->end_date < \Carbon\Carbon::now()->toDateString() ? 'text-danger' : 'text-success' }}">
                                    {{ $subscription->start_date->format('j M Y') }}
                                    <br>
                                    {{ $subscription->end_date->format('j M Y') }}
                                </td>

                                {{-- updated --}}
                                <td class="text-right">
                                    <span data-rel="tooltip" title="{{ $client->updated_at }}">
                                    {{ $client->updated_at->format('j M Y') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                                @include('partials.noentries', ['text' => 'No Subscriptions Found!'])
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('page_title', 'Clients')

@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="card">
                <div class="card-body px-3">
                    <dl class="row">
                        {{-- name --}}
                        <dt class="col-sm-3 text-sm-right text-muted">
                            <i class="far fa-user-circle fa-3x"></i>
                        </dt>
                        <dd class="col-sm-9">
                            <h5>
                                {{ $client->name }}<br>
                                <span class="small text-muted">
                                    Status:
                                    @include('clients.status-form', ['model' => $client, 'iconClass' => '', 'text' => 1])
                                </span>
                            </h5>
                            {{-- edit --}}
                            @can('update', $client)
                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-secondary"><i class="far fa-edit fa-fw"></i> Edit</a>
                            @endcan
                        </dd>
                    </dl>

                    <dl class="row border-top border-bottom py-2">
                        <dt class="col-sm-3 text-sm-right text-muted">
                            Contact Info
                        </dt>
                        <dd class="col-sm-9"></dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-3 text-sm-right text-muted">
                            E-Mail:
                        </dt>
                        <dd class="col-sm-9">
                            @if ($client->email)
                                <i class="fas fa-envelope fa-fw text-muted"></i> {{ $client->email }}
                            @endif
                        </dd>

                        <dt class="col-sm-3 text-sm-right text-muted">
                            Phone:
                        </dt>
                        <dd class="col-sm-9">
                            @if ($client->phone)
                                <i class="fas fa-phone fa-fw text-muted"></i> {{ $client->phone }}
                            @endif
                        </dd>

                        <dt class="col-sm-3 text-sm-right text-muted">
                            Address:
                        </dt>
                        <dd class="col-sm-9">
                            @if ($client->address)
                                <i class="fas fa-map-marker-alt fa-fw text-muted"></i> {{ $client->address }}
                            @endif

                        </dd>

                        <dt class="col-sm-3 text-sm-right text-muted">
                            Contact Person:
                        </dt>
                        <dd class="col-sm-9">
                            @if ($client->contact_person)
                                <i class="fas fa-user-tie fa-fw text-muted"></i> {{ $client->contact_person }}
                            @endif
                        </dd>
                    </dl>

                    <dl class="row border-top border-bottom py-2">
                        <dt class="col-sm-3 text-sm-right text-muted">
                            Subscriptions
                        </dt>
                        <dd class="col-sm-9"></dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-3 text-sm-right text-muted">
                            Types:
                        </dt>
                        <dd class="col-sm-9">
                            @forelse ($client->subscriptions as $subscription)
                                <a href="{{ route('subscriptions.show', $subscription) }}" class="mr-2">
                                    <i class="fas fa-external-link-alt fa-fw"></i>
                                    {{ $subscription->type->display_name }}
                                </a>
                                [<span class="small font-weight-bold {{ $subscription->end_date < \Carbon\Carbon::now()->toDateString() ? 'text-danger' : 'text-success' }}">
                                    {{ $subscription->start_date->format('j M Y') }} -
                                    {{ $subscription->end_date->format('j M Y') }}
                                </span>]
                                <br>
                            @empty
                                <p>No Subscriptions Found!<br>
                                    <a href="{{ route('subscriptions.create') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-plus"></i> Add New</a>
                                </p>
                            @endforelse
                        </dd>

                        <dt class="col-sm-3 text-sm-right text-muted">
                            E-Mails:
                        </dt>
                        <dd class="col-sm-9">
                            {!! implode(',<br>', $client->emails->pluck('email')->toArray()) !!}
                        </dd>

                        <dt class="col-sm-3 text-sm-right text-muted">
                            Comment:
                        </dt>
                        <dd class="col-sm-9">
                            {!! $client->comment !!}
                        </dd>
                    </dl>

                    <dl class="row border-top border-bottom py-2">
                        <dt class="col-sm-3 text-sm-right text-muted">
                            System
                        </dt>
                        <dd class="col-sm-9"></dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-3 text-sm-right text-muted">
                            Created at:
                        </dt>
                        <dd class="col-sm-9">
                            {{ $client->created_at->format('j M Y') }}
                        </dd>

                        <dt class="col-sm-3 text-sm-right text-muted">
                            Updated at:
                        </dt>
                        <dd class="col-sm-9">
                            {{ $client->updated_at->format('j M Y') }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection

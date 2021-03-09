@extends('layouts.app')

@section('page_title', 'Subscriptions')

@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="card">
                <div class="card-body px-3">
                    <dl class="row">
                        {{-- name --}}
                        <dt class="col-sm-3 text-sm-right text-muted">
                            <i class="far fa-check-circle fa-3x"></i>
                        </dt>
                        <dd class="col-sm-9">
                            <h5>
                                #{{ $subscription->id }}<br>
                                <span class="small text-muted">
                                    {{ $subscription->type->display_name }}
                                </span>
                            </h5>
                            {{-- edit --}}
                            @can('update', $subscription)
                            <a href="{{ route('subscriptions.edit', $subscription) }}" class="btn btn-sm btn-outline-secondary"><i class="far fa-edit fa-fw"></i> Edit</a>
                            @endcan
                        </dd>
                    </dl>

                    <dl class="row border-top border-bottom py-2">
                        <dt class="col-sm-3 text-sm-right text-muted">
                            Details
                        </dt>
                        <dd class="col-sm-9"></dd>
                    </dl>

                    <dl class="row">
                        <dt class="col-sm-3 text-sm-right text-muted">
                            Client:
                        </dt>
                        <dd class="col-sm-9">
                            @include('clients.status-form', ['model' => $subscription->client, 'iconClass' => 'fa-fw'])
                            <a href="{{ route('clients.show', $subscription->client) }}">{{ $subscription->client->name }}</a>
                        </dd>

                        <dt class="col-sm-3 text-sm-right text-muted">
                            Type:
                        </dt>
                        <dd class="col-sm-9">
                            {{ $subscription->type->display_name }}
                        </dd>

                        @if ($subscription->type->name == 'clip')
                        <dt class="col-sm-3 text-sm-right text-muted">
                            Topics:
                        </dt>
                        <dd class="col-sm-9">
                            @forelse ($subscription->topics as $topic)
                                <span class="badge badge-secondary" data-rel="tooltip" title="{{ $topic->name }}">
                                    {{ $topic->number }}
                                </span>
                            @empty
                                <span class="small text-danger">No topics found!</span>
                            @endforelse
                        </dd>
                        @endif

                        <dt class="col-sm-3 text-sm-right text-muted">
                            E-Mails:
                        </dt>
                        <dd class="col-sm-9">
                            {!! implode(',<br>', $subscription->emails->pluck('email')->toArray()) !!}
                        </dd>

                        <dt class="col-sm-3 text-sm-right text-muted">
                            Period:
                        </dt>
                        <dd class="col-sm-9">
                            <span class="small font-weight-bold {{ $subscription->end_date < \Carbon\Carbon::now()->toDateString() ? 'text-danger' : 'text-success' }}">
                                {{ $subscription->start_date->format('j M Y') }} -
                                {{ $subscription->end_date->format('j M Y') }}
                            </span>
                        </dd>

                        <dt class="col-sm-3 text-sm-right text-muted">
                            Comment:
                        </dt>
                        <dd class="col-sm-9">
                            {!! $subscription->client->comment !!}
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
                            {{ $subscription->created_at->format('j M Y') }}
                        </dd>

                        <dt class="col-sm-3 text-sm-right text-muted">
                            Updated at:
                        </dt>
                        <dd class="col-sm-9">
                            {{ $subscription->updated_at->format('j M Y') }}
                        </dd>
                    </dl>

                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection

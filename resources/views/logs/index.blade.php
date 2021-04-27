@extends('layouts.app')

@section('page_title', 'Logs')

@section('page_buttons')
    @can('deleteAll', 'App\Activity')
        <form method="POST" class="d-inline form-delete" action="{{ route('activity.destroy') }}">
            @method('DELETE')
            @csrf
            <a href="" class="btn btn-sm btn-outline-secondary">
                <i class="far fa-trash-alt fa-fw"></i> Empty Logs
            </a>
        </form>
    @endcan
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">

            <div class="card mt-3 tab-card">
                <div class="card-header tab-card-header">
                    <ul class="nav nav-tabs card-header-tabs">

                        {{-- tab-all --}}
                        <li class="nav-item">
                            <a class="nav-link {{ isActiveRoute('logs.index') }}" href="{{ route('logs.index') }}">
                                All
                            </a>
                        </li>

                        {{-- tab-clients --}}
                        <li class="nav-item">
                            <a class="nav-link {{ isActiveUrl(route('logs.by_name', 'clients')) }}" href="{{ route('logs.by_name', 'clients') }}">
                                Clients
                            </a>
                        </li>

                        {{-- tab-dn --}}
                        <li class="nav-item">
                            <a class="nav-link {{ isActiveUrl(route('logs.by_name', 'dn')) }}" href="{{ route('logs.by_name', 'dn') }}">
                                Subscriptions DN
                            </a>
                        </li>

                        {{-- tab-clip --}}
                        <li class="nav-item">
                            <a class="nav-link {{ isActiveUrl(route('logs.by_name', 'clip')) }}" href="{{ route('logs.by_name', 'clip') }}">
                                Subscriptions CLIP
                            </a>
                        </li>

                        {{-- tab-topics --}}
                        <li class="nav-item">
                            <a class="nav-link {{ isActiveUrl(route('logs.by_name', 'topics')) }}" href="{{ route('logs.by_name', 'topics') }}">
                                Topics
                            </a>
                        </li>

                        {{-- tab-users --}}
                        <li class="nav-item">
                            <a class="nav-link {{ isActiveUrl(route('logs.by_name', 'users')) }}" href="{{ route('logs.by_name', 'users') }}">
                                Users
                            </a>
                        </li>

                        {{-- sent-dn --}}
                        <li class="nav-item">
                            <a class="nav-link {{ isActiveUrl(route('logs.by_name', 'SENT-DAILY-NEWS')) }}" href="{{ route('logs.by_name', 'SENT-DAILY-NEWS') }}">
                                Sent DN
                            </a>
                        </li>

                        {{-- sent-clip --}}
                        <li class="nav-item">
                            <a class="nav-link {{ isActiveUrl(route('logs.by_name', 'SENT-CLIP')) }}" href="{{ route('logs.by_name', 'SENT-CLIP') }}">
                                Sent CLIP
                            </a>
                        </li>

                        {{-- sent-clip --}}
                        <li class="nav-item">
                            <a class="nav-link {{ isActiveUrl(route('logs.by_name', 'ARCHIVED')) }}" href="{{ route('logs.by_name', 'ARCHIVED') }}">
                                Archived
                            </a>
                        </li>

                    </ul>
                </div>

                <div class="tab-content">
                    {{-- pane-all --}}
                    <div class="tab-pane p-3 {{ isActiveRoute('logs.index') }}">
                        @include('logs.activity')
                    </div>

                    {{-- pane-clients --}}
                    <div class="tab-pane p-3 {{ isActiveUrl(route('logs.by_name', 'clients')) }}">
                        @include('logs.activity')
                    </div>

                    {{-- pane-dn --}}
                    <div class="tab-pane p-3 {{ isActiveUrl(route('logs.by_name', 'dn')) }}">
                        @include('logs.activity')
                    </div>

                    {{-- pane-dn --}}
                    <div class="tab-pane p-3 {{ isActiveUrl(route('logs.by_name', 'clip')) }}">
                        @include('logs.activity')
                    </div>

                    {{-- pane-topics --}}
                    <div class="tab-pane p-3 {{ isActiveUrl(route('logs.by_name', 'topics')) }}">
                        @include('logs.activity')
                    </div>

                    {{-- pane-users --}}
                    <div class="tab-pane p-3 {{ isActiveUrl(route('logs.by_name', 'users')) }}">
                        @include('logs.activity')
                    </div>

                    {{-- pane-sent-dn --}}
                    <div class="tab-pane p-3 {{ isActiveUrl(route('logs.by_name', 'SENT-DAILY-NEWS')) }}">
                        @include('logs.activity')
                    </div>

                    {{-- pane-sent-clip --}}
                    <div class="tab-pane p-3 {{ isActiveUrl(route('logs.by_name', 'SENT-CLIP')) }}">
                        @include('logs.activity')
                    </div>

                    {{-- pane-sent-clip --}}
                    <div class="tab-pane p-3 {{ isActiveUrl(route('logs.by_name', 'ARCHIVED')) }}">
                        @include('logs.activity')
                    </div>

                </div>
            </div>

            <div class=" mt-3">
                {{ $logs->links() }}
            </div>

        </div>
    </div>
@endsection

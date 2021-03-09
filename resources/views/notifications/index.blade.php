@extends('layouts.app')

@section('page_title', $pageTitle ?? 'Notifications')

@section('page_buttons')

    <div class="btn-group">
    <form method="POST" class="d-inline" action="{{ route('notifications.read_all') }}">
        @method('DELETE')
        @csrf
        <a href="" class="ormSubmit btn btn-sm btn-outline-secondary" title="Mark all notifications as read" data-rel="ooltip">
            <i class="far fa-eye"></i> Mark all as read
        </a>
    </form>

    <form method="POST" class="d-inline" action="{{ route('notifications.delete_all') }}">
        @method('DELETE')
        @csrf
        <a href="" class="formSubmit btn btn-sm btn-outline-secondary ml-3" title="Mark all notifications as read" data-rel="tooltip">
            <i class="far fa-trash-alt"></i> Delete all
        </a>
    </form>
    </div>

@endsection

@section('content')

    <table class="table table-striped table-sm" id="dTable">
        <thead>
            <tr>
                <th class="w-50">Notification</th>
                <th class="text-right">Created</th>
                <th class="text-right">Updated</th>
                <th class="text-right">Read</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($notifications as $notification)
            <tr>
                <td>
                    <a href="{{ route('notifications.show', [$notification]) }}">
                        {{ $notification->data['user'] }}
                        {{ $notification->data['event'] }}
                        #{{ $notification->data['id'] }}
                    </a>
                </td>

                <td class="text-right">
                    {{ $notification->created_at->format('j M Y, H:i') }}
                </td>

                <td class="text-right">
                    {{ $notification->updated_at->format('j M Y, H:i') }}
                </td>

                <td class="text-right">
                    @if (! is_null($notification->read_at))
                        {{ $notification->read_at->format('j M Y, H:i') }}
                    @endif
                </td>

                <td class="text-right text-nowrap">
                    {{-- read --}}
                    @if (! $notification->read_at)
                        <form class="d-inline" method="POST" action="{{ route('notifications.update', $notification) }}">
                            @method('PATCH')
                            @csrf
                            <a href="" class="formSubmit icon-read" data-rel="tooltip" title="Mark as Read"><i class="far fa-eye fa-lg fa-fw"></i></a>
                        </form>
                    @endif


                    {{-- delete --}}
                    <form method="POST" class="d-inline form-delete" action="{{ route('notifications.destroy', $notification) }}">
                        @method('DELETE')
                        @csrf
                        <a href="" class="ml-2 icon-delete" data-rel="tooltip" title="Delete Notification"><i class="far fa-trash-alt fa-fw fa-lg"></i></a>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    @include('partials.noentries', ['text' => 'No Notifications Found!'])
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection

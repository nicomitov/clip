@extends('layouts.app')

@section('page_title', $pageTitle ?? 'Topics Pressclipping')

@section('page_buttons')
    @can('create', 'App\Topic')
    <a href="{{ route('topics.create') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-plus"></i> Add New
    </a>
    @endcan
@endsection

@section('content')

    <table class="table table-striped table-sm" id="dTable">
        <thead>
            <tr>
                <th>Number / Name</th>
                <th class="text-right">Created</th>
                <th class="text-right">Updated</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($topics as $topic)
            <tr>
                <td>
                    <span class="badge badge-secondary mr-2">{{ $topic->number }}</span>
                    {{ $topic->name }}
                </td>
                <td class="text-right">
                    <span data-rel="tooltip" title="{{  $topic->created_at }}">{{ $topic->created_at->format('j M Y') }}</span>
                </td>
                <td class="text-right">
                    <span data-rel="tooltip" title="{{  $topic->updated_at }}">{{ $topic->updated_at->format('j M Y') }}</span>
                </td>
                <td class="text-right text-nowrap">
                    {{-- edit --}}
                    @can('update', $topic)
                    <a href="{{ route('topics.edit', $topic) }}" class="icon-edit mr-3" data-rel="tooltip" title="Edit Topic"><i class="far fa-edit fa-fw fa-lg"></i></a>
                    @endcan

                    {{-- delete --}}
                    @can('delete', $topic)
                    <form method="POST" class="d-inline form-delete" action="{{ route('topics.destroy', $topic) }}">
                        @method('DELETE')
                        @csrf
                        <a href="" class="icon-delete" data-rel="tooltip" title="Delete Topic"><i class="far fa-trash-alt fa-fw fa-lg"></i></a>
                    </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    @include('partials.noentries', ['text' => 'No Topics Found!'])
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection

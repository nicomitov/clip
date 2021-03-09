@extends('layouts.app')

@section('page_title', $page->title)

@section('page_buttons')
    @can('update', $page)
    <a href="{{ route('pages.edit', $page) }}" class="btn btn-sm btn-outline-secondary">
        <i class="far fa-edit fa-fw"></i> Edit
    </a>
    @endcan
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8 offset-xl-2">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted small text-right">
                        Updated:
                        <span data-rel="tooltip" title="{{$page->updated_at->format('j M Y, H:i')}}">{{ $page->updated_at->diffForHumans() }}</span>
                    </p>

                    {!! $page->body !!}
                </div>
            </div>
        </div>
    </div>
@endsection

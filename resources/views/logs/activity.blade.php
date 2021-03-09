@forelse ($logs as $log)
    <p class="font-weight-bold mb-2">
        {{-- date --}}
        <span class="mr-2">
            {{ $log->created_at->format('j M Y, H:i') }}
        </span>

        {{-- name --}}
        @if ($log->causer)
            {{ $log->causer->name }}
        @endif

        {{-- event --}}
        <span class="text-{{ $log->description }}">
            {{ $log->description }}
        </span>

        {{-- subject --}}
        @if ($log->log_name == 'dn')
            a Daily News Subscription
        @elseif ($log->log_name == 'clip')
            a Pressclipping Subscription
        @elseif ($log->log_name == 'users')
            an user
        @elseif ($log->log_name == 'SENT-DAILY-NEWS' || $log->log_name == 'SENT-CLIP')
            <span class="text-success">{{ $log->log_name }}</span>
        @elseif ($log->log_name == 'ARCHIVED')
            <span class="text-danger">{{ $log->log_name }}</span>
        @else
            a {{ Str::singular($log->log_name) }}
        @endif

        {{-- id --}}
        @if ($log->log_name == 'dn' || $log->log_name == 'clip')
            <a href="{{ route('subscriptions.show', $log->subject_id) }}">
                {{ '#'.$log->subject_id.':' }}
            </a>
        @elseif ($log->log_name == 'clients')
            <a href="{{ route($log->log_name.'.show', $log->subject_id) }}">
                {{ '#'.$log->subject_id.':' }}
            </a>
        @elseif ($log->log_name == 'users' || $log->log_name == 'topics')
            @role('admin')
                <a href="{{ route($log->log_name.'.edit', $log->subject_id) }}">
                    {{ '#'.$log->subject_id.':' }}
                </a>
            @else
                {{ '#'.$log->subject_id.':' }}
            @endrole
        @endif
    </p>

    @forelse($log->changes['attributes'] as $key => $value)
        @if ($key == 'Topics' && $log->log_name == 'dn')
            @continue
        @endif

        <div class="row pb-1">
            <div class="col-md-3 col-lg-2 text-md-right pr-md-0">
                <div class="text-muted">
                    {{ $key }}:
                </div>
            </div>
            <div class="col-md-9 col-lg-10">
                {!! $value !!}
            </div>
        </div>
    @empty
        @include('partials.noentries', ['text' => 'No Data!'])
    @endforelse
    <hr>

@empty
    @include('partials.noentries', ['text' => 'No Data!'])
@endforelse

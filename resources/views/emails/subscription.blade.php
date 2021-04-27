@component('mail::message')
# Hi there!

<p>A {{ $type }} subscription #{{ $id }} has been {{ $event }} by {{ $user }}:</p>

@component('mail::panel')
<p>
<strong>Client:</strong><br>
{{ $client }}
</p>

<p>
<strong>E-Mails:</strong><br>
{!! $emails !!}
</p>

<p>
<strong>Period:</strong><br>
{{ $period }}
</p>
@endcomponent

@component('mail::button', ['url' => $url])
Check It Out
@endcomponent

Have fun,<br />
{{ config('app.name') }}
@endcomponent

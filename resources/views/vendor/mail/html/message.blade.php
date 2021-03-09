@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.bta_url')])
{{-- {{ config('app.bta_name') }} --}}
<img src="{{ config('app.bta_logo') }}" alt="BULGARIAN NEWS AGENCY">
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
<a href="{{ config('app.bta_contacts_url') }}">Contacts</a>
<a href="{{ config('app.bta_terms_url') }}">Terms of Use</a>
<p>
© {{ date('Y') }} {{ config('app.bta_name') }}. @lang('All rights reserved.')
</p>
@endcomponent
@endslot
@endcomponent

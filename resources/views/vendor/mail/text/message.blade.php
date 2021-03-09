@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.bta_url')])
            {{ config('app.bta_name') }}
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
Contacts ({{ config('app.bta_contacts_url') }})
Terms of Use ({{ config('app.bta_terms_url') }})
            <p>
© {{ date('Y') }} {{ config('app.bta_name') }}. @lang('All rights reserved.')
            </p>
        @endcomponent
    @endslot
@endcomponent

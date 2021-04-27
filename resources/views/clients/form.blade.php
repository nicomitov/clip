{{-- name --}}
<div class="form-group required row">
    <label for="name" class="col-lg-2 col-form-label">Name:</label>
    <div class="col-lg-10">
        <input
            type="text"
            class="form-control @error('name') is-invalid @enderror"
            id="name"
            name="name"
            value="{{ isset($client) ? $client->name : old('name') }}"
            placeholder="Client Name">

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- email --}}
<div class="form-group row">
    <label for="email" class="col-lg-2 col-form-label">Contact E-Mail:</label>
    <div class="col-lg-10">
        <input
            type="email"
            class="form-control @error('email') is-invalid @enderror"
            id="email"
            name="email"
            value="{{ isset($client) ? $client->email : old('email') }}"
            placeholder="Contact E-Mail Address"
            @unlessrole('admin') disabled @endrole>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- phone --}}
<div class="form-group row">
    <label for="phone" class="col-lg-2 col-form-label">Phone:</label>
    <div class="col-lg-10">
        <input
            type="text"
            class="form-control @error('phone') is-invalid @enderror"
            id="phone"
            name="phone"
            value="{{ isset($client) ? $client->phone : old('phone') }}"
            placeholder="Contact Phone">

        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- contact_person --}}
<div class="form-group row">
    <label for="contact_person" class="col-lg-2 col-form-label">Contact Person:</label>
    <div class="col-lg-10">
        <input
            type="text"
            class="form-control @error('contact_person') is-invalid @enderror"
            id="contact_person"
            name="contact_person"
            value="{{ isset($client) ? $client->contact_person : old('contact_person') }}"
            placeholder="Contact Person">

        @error('contact_person')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- address --}}
<div class="form-group row">
    <label for="address" class="col-lg-2 col-form-label">Address:</label>
    <div class="col-lg-10">
        <input
            type="text"
            class="form-control"
            id="address"
            name="address"
            value="{{ isset($client) ? $client->address : old('address') }}"
            placeholder="Client Address">
    </div>
</div>

{{-- is_active --}}
<div class="form-group row">
    <div class="col-lg-2">Status:</div>
    <div class="col-lg-10">
        <div class="form-check custom-control custom-checkbox">
            <input
                class="form-check-input custom-control-input"
                type="checkbox"
                name="is_active"
                id="is_active"
                {{ old('is_active') ? 'checked' : '' }}
                @if (isset($client) && $client->is_active)
                    checked
                @endif>
            <label class="form-check-label custom-control-label" for="is_active">{{ __('Active') }}</label>
        </div>
    </div>
</div>

{{-- comment --}}
<div class="form-group row">
    <label for="comment" class="col-lg-2 col-form-label">Comment:</label>
    <div class="col-lg-10">
        <textarea
            class="form-control @error('comment') is-invalid @enderror"
            id="comment"
            name="comment"
            rows="6"
            placeholder="Comment"
        >{{ isset($client) ? $client->comment : old('comment') }}</textarea>
    </div>
</div>
<hr>

{{-- subscription emails --}}
<div class="form-group required row">
    <label for="subscription_emails" class="col-lg-2 col-form-label">Subscription E-Mails:</label>
    <div class="col-lg-10">
        <div class="alert alert-info">
            <i class="fas fa-info fa-lg fa-fw"></i>
            The Subscription E-Mail Addresses, must be separated by <strong>","</strong>
        </div>
        <textarea
            class="form-control @error('subscription_emails') is-invalid @enderror"
            id="subscription_emails"
            name="subscription_emails"
            rows="6"
            placeholder="email1@domain.com, email2@domain.com, email3@domain.com"
        >{{ isset($client) ? $clientEmails : old('subscription_emails') }}</textarea>

        @error('subscription_emails')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- submit --}}
<div class="form-group row">
    <div class="col-sm-10">
        @include('partials.btn_submit', ['text' => 'Save Client'])
    </div>
</div>

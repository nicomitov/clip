{{-- client_id --}}
<div class="form-group required row">
    <label for="client_id" class="col-lg-2 col-form-label">Client:</label>
    <div class="col-lg-10">
        <select
            id="client_id"
            class="bsmultiselect custom-select @error('client_id') is-invalid @enderror"
            name="client_id">
            <option>Please Select...</option>
            @isset($clients)
            @foreach ($clients as $id => $name)
                <option
                    value="{{ $id }}"
                    @if (isset($subscription) && $subscription->client_id == $id) selected @endif>
                    {{ $name }}
                </option>
            @endforeach
            @endisset
        </select>

        @error('client_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- emails --}}
<div class="form-group required row">
    <label for="toEmails" class="col-lg-2 col-form-label">Client Emails:</label>
    <div class="col-lg-10">
        <select
            id="toEmails"
            class="bsmultiselect custom-select @error('toEmails') is-invalid @enderror"
            name="toEmails[]"
            data-non_selected_text="Please Select..."
            multiple>
            @isset ($subscription)
                @foreach ($subscription->client->emails as $email)
                    <option
                        value="{{ $email->id }}"
                        @if ($subscription->emails->contains($email)) selected @endif>
                        {{ $email->email }}
                    </option>
                @endforeach
            @else

            @endisset
        </select>

        @error('toEmails')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- type --}}
<div class="form-group required row">
    <label for="subscription_type_id" class="col-lg-2 col-form-label">Subscription:</label>
    <div class="col-lg-10">
        @foreach ($types as $id => $name)
            <div class="custom-control custom-radio">
                <input
                    type="radio"
                    id="{{ $name }}"
                    name="subscription_type_id"
                    value="{{ $id }}"
                    class="custom-control-input @error('subscription_type_id') is-invalid @enderror"
                    data-topics="{{ $topics }}"
                    data-selected_topics="@isset($selectedTopics){{ $selectedTopics }}@endisset"
                    {{ old('subscription_type_id') == $id ? 'checked' : '' }}
                    @if (isset($subscription) && $subscription->subscription_type_id == $id)
                        checked
                    @endif>
                <label class="custom-control-label" for="{{ $name }}">{{ $name }}</label>
            </div>
        @endforeach

        @error('subscription_type_id')
            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- topics --}}
<div id="append">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">
            @error('toTopics')
                <div class="invalid-feedback" style="display: block; margin-top: -10px; margin-bottom: 20px;">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- start - end --}}
<div class="form-group required row">
    <label for="" class="col-lg-2 col-form-label">Period:</label>
    <div class="col-lg-10">
        <div class="row">
            {{-- start --}}
            <div class="col-6">
                <label for="start_date">Start Date</label>
                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    value="{{ isset($subscription) ? $subscription->start_date->toDateString() : old('start_date') }}"
                    class="form-control @error('start_date') is-invalid @enderror">

                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- end --}}
            <div class="col-6">
                <label for="start_date">End Date</label>
                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    value="{{ isset($subscription) ? $subscription->end_date->toDateString() : old('end_date') }}"
                    class="form-control @error('end_date') is-invalid @enderror">

                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
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
        >{{ isset($subscription) ? $subscription->client->comment : old('comment') }}</textarea>
    </div>
</div>

{{-- submit --}}
<div class="form-group row">
    <div class="col-sm-10">
        @include('partials.btn_submit', ['text' => 'Save Subscription'])
    </div>
</div>

{{-- number --}}
<div class="form-group required row">
    <label for="number" class="col-lg-2 col-form-label">Number:</label>
    <div class="col-lg-10">
        <input
            type="number"
            class="form-control @error('number') is-invalid @enderror"
            id="number"
            name="number"
            value="{{ isset($topic) ? $topic->number : old('number') }}"
            placeholder="Must be at unique!">

        @error('number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- name --}}
<div class="form-group required row">
    <label for="name" class="col-lg-2 col-form-label">Name:</label>
    <div class="col-lg-10">
        <input
            type="text"
            class="form-control @error('name') is-invalid @enderror"
            id="name"
            name="name"
            value="{{ isset($topic) ? $topic->name : old('name') }}"
            placeholder="Must be at least 3 characters!">

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- submit --}}
<div class="form-group row">
    <div class="col-sm-10">
        @include('partials.btn_submit', ['text' => 'Save Topic'])
    </div>
</div>

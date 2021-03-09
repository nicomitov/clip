{{-- title --}}
<div class="form-group required row">
    <label for="title" class="col-lg-2 col-form-label">Title:</label>
    <div class="col-lg-10">
        <input
            type="text"
            class="form-control @error('title') is-invalid @enderror"
            id="title"
            name="title"
            value="{{ isset($page) ? $page->title : old('title') }}"
            placeholder="Must be at least 3 characters!">

        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- body --}}
<div class="form-group required row">
    <label for="body" class="col-lg-2 col-form-label">Body:</label>
    <div class="col-lg-10">
        <textarea
            class="form-control @error('body') is-invalid @enderror"
            id="body"
            name="body"
            rows="24"
            placeholder=""
        >{!! isset($page) ? $page->body : old('body') !!}</textarea>

        @error('body')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- submit --}}
<div class="form-group row">
    <div class="col-sm-10">
        @include('partials.btn_submit', ['text' => 'Save Page'])
    </div>
</div>

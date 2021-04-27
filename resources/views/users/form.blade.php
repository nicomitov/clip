{{-- name --}}
<div class="form-group required row">
    <label for="name" class="col-lg-2 col-form-label">Name:</label>
    <div class="col-lg-10">
        <input
            type="text"
            class="form-control @error('name') is-invalid @enderror"
            id="name"
            name="name"
            value="{{ isset($user) ? $user->name : old('name') }}"
            placeholder="Must be at least 3 characters!">

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- email --}}
<div class="form-group required row">
    <label for="email" class="col-lg-2 col-form-label">E-Mail Address:</label>
    <div class="col-lg-10">
        <input
            type="email"
            class="form-control @error('email') is-invalid @enderror"
            id="email"
            name="email"
            value="{{ isset($user) ? $user->email : old('email') }}"
            placeholder="E-Mail Address"
            @unlessrole('admin') disabled @endrole>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- password --}}
<div class="form-group required row">
    <label for="password" class="col-lg-2 col-form-label">
        {{ Route::currentRouteName() == 'users.edit' ? 'New Password:' : 'Password:' }}
    </label>
    <div class="col-lg-10">
        <input
            type="password"
            class="form-control @error('password') is-invalid @enderror"
            id="password"
            name="password"
            placeholder="Must be at least 4 characters!">

        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- password_confirmation --}}
@if (Route::currentRouteName() == 'users.edit')
    <div class="form-group required row">
        <label for="password_confirmation" class="col-lg-2 col-form-label">Password Confirm:</label>
        <div class="col-lg-10">
            <input
                type="password"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Must be at least 4 characters!">

            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endif

{{-- department --}}
<div class="form-group row">
    <label for="department" class="col-lg-2 col-form-label">Department:</label>
    <div class="col-lg-10">
        <input
            type="text"
            class="form-control"
            id="department"
            name="department"
            value="{{ isset($user) ? $user->department : old('department') }}"
            placeholder="Department">
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
                @if (isset($user) && $user->is_active)
                    checked
                @endif>
            <label class="form-check-label custom-control-label" for="is_active">{{ __('Active') }}</label>
        </div>
    </div>
</div>

{{-- notify --}}
<div class="form-group row">
    <div class="col-lg-2">Notifications:</div>
    <div class="col-lg-10">
        <div class="form-check custom-control custom-checkbox">
            <input
                class="form-check-input custom-control-input"
                type="checkbox"
                name="notify"
                id="notify"
                {{ old('notify') ? 'checked' : '' }}
                @if (isset($user) && $user->notify)
                    checked
                @endif>
            <label class="form-check-label custom-control-label" for="notify">{{ __('Send notifications to e-mail.') }}</label>
        </div>
    </div>
</div>

{{-- roles --}}
<div class="form-group required row">
    <label for="toRoles" class="col-lg-2 col-form-label">Roles:</label>
    <div class="col-lg-10">
        <select
            class="custom-select @error('toRoles') is-invalid @enderror"
            name="toRoles[]"
            size="3"
            multiple
            @unlessrole('admin') disabled @endrole>
            @foreach ($roles as $id => $name)
                <option
                    value="{{ $id }}"
                    @if (isset($userRoles) && $userRoles->contains($id)) selected @endif>
                    {{ $name }}
                </option>
            @endforeach
        </select>

        @error('toRoles')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- submit --}}
<div class="form-group row">
    <div class="col-sm-10">
        @include('partials.btn_submit', ['text' => 'Save User'])
    </div>
</div>

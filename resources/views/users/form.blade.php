@if ($action == 'create' || $action == 'update')
<div class="form-group">
    <label for="name">Username</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}" id="name" class="form-control @error('name') is-invalid @enderror">
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <label for="email">E-Mail Address</label>
    <input type="text" name="email" value="{{ old('email', $user->email) }}" id="email" class="form-control @error('email') is-invalid @enderror">
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@endif
@if ($action == 'create' || $action == 'change_password')
<div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <label for="password-confirm">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password-confirm" class="form-control @error('password') is-invalid @enderror">
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@endif
<div class="form-group">
    <input type="hidden" name="action" value="{{ $action }}">
    <button type="submit" class="btn btn-outline-primary">{{ $button_text }}</button>
</div>
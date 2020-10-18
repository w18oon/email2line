<div class="form-group">
    <label for="name">Group name</label>
    <input type="text" name="name" value="{{ old('name', $group->name) }}" id="name" class="form-control @error('name') is-invalid @enderror">
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <label for="token">Line Access Token</label>
    <input type="text" name="token" value="{{ old('token', $group->token) }}" id="token" class="form-control @error('token') is-invalid @enderror">
    @error('token')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary">{{ $button_text }}</button>
</div>
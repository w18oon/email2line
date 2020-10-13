<div class="form-group">
    <label for="subject">Subject</label>
    <input type="text" name="subject" value="{{ old('subject', $lookup->subject) }}" id="subject" class="form-control {{ $errors->has('subject') ? 'is-invalid': null }}">
    @if($errors->has('subject'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('subject') }}</strong>
    </div>
    @endif
</div>
<div class="form-group">
    <label for="token">Line Access Token</label>
    <input type="text" name="token" value="{{ old('token', $lookup->token) }}" id="token" class="form-control {{ $errors->has('token') ? 'is-invalid': null }}">
    @if($errors->has('token'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('token') }}</strong>
    </div>
    @endif
</div>
<div class="form-group">
    <label for="remarks">Remarks</label>
    <input type="text" name="remarks" value="{{ old('remarks', $lookup->remarks) }}" id="remarks" class="form-control">
</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary">{{ $button_text }}</button>
</div>
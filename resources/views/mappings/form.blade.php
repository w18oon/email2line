<div class="form-group">
    <label for="subject">E-Mail Subject</label>
    <input type="text" name="subject" value="{{ old('subject', $mapping->subject) }}" id="subject" class="form-control @error('subject') is-invalid @enderror">
    @error('subject')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <label for="group_id">Group name</label>
    <select class="custom-select @error('group_id') is-invalid @enderror" name="group_id" id="group_id">
        @foreach ($groups as $group)
        <option value="{{ $group->id }}">{{ $group->name }}</option>
        @endforeach
    </select>
    @error('group_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <button type="submit" class="btn btn-outline-primary">{{ $button_text }}</button>
</div>
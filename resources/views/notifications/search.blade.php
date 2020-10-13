@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        Search Notification
                        <div class="ml-auto">
                            <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary btn-sm">All Notifications</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('result-notification') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select class="custom-select" name="subject" id="subject">
                                @foreach ($lookups as $lookup)
                                <option value="{{ $lookup->id }}">{{ $lookup->subject . ' (' . $lookup->remarks .')' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="created">Send Date</label>
                            <input type="text" name="created" id="created" class="form-control" placeholder="YYYY-MM-DD">
                            <small id="passwordHelpBlock" class="form-text text-muted">Example 2020-01-01</small>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

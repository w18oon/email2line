@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        Search
                        <div class="ml-auto">
                            <a href="{{ route($base_route . '.index') }}" class="btn btn-outline-secondary btn-sm">Back to all {{ $base_route }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route($base_route . '.result') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="group">Group name</label>
                            <select class="custom-select" name="group" id="group">
                                @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="created">Send at</label>
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

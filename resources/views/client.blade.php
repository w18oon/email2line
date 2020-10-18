@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Gamil Auth') }}</div>
                <div class="card-body">
                    @isset($redirect_to)
                    <a class="btn btn-primary" href="{{ $redirect_to }}" role="button">Authen by Gmail</a>
                    @else
                    <a class="btn btn-danger" href="{{ route('gmail-revoke') }}" role="button">Revoke Credential</a>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

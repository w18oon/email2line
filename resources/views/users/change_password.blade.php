@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        Edit user
                        <div class="ml-auto">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">Back to all users</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        @include('users.form', ['action' => 'change_password', 'button_text' => 'Update user'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

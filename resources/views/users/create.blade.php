@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        Create user
                        <div class="ml-auto">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">Back to all user</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf
                        @include('users.form', ['action' => 'create', 'button_text' => 'Creat user'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        Create Group
                        <div class="ml-auto">
                            <a href="{{ route('groups.index') }}" class="btn btn-outline-secondary btn-sm">Back to  all groups</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('groups.store') }}" method="post">
                        @csrf
                        @include('groups.form', ['button_text' => 'Create group'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

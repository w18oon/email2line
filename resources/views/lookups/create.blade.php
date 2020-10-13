@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        Create Lookup
                        <div class="ml-auto">
                            <a href="{{ route('lookups.index') }}" class="btn btn-outline-secondary btn-sm">All Lookup</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('lookups.store') }}" method="post">
                        @csrf
                        @include('lookups.form', ['button_text' => 'Create Lookup'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        Create {{ Str::singular($base_route) }}
                        <div class="ml-auto">
                            <a href="{{ route($base_route . '.index') }}" class="btn btn-outline-secondary btn-sm">Back to all {{ $base_route }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route($base_route . '.store') }}" method="post">
                        @csrf
                        @include($base_route . '.form', ['button_text' => 'Create ' . Str::singular($base_route)])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

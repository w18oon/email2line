@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        Edit group
                        <div class="ml-auto">
                            <a href="{{ route('groups.index') }}" class="btn btn-outline-secondary btn-sm">Back to all groups</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('groups.update', $group->id) }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        @include('groups.form', ['button_text' => 'Update group'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

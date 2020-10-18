@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        All Groups
                        <div class="ml-auto">
                            <a href="{{ route('groups.create') }}" class="btn btn-outline-secondary btn-sm">Create Group</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        @include('layouts.alert')
                    @endif
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Group Name</th>
                                <th>Line Access Token</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($groups as $group)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->token }}</td>
                                <td>{{ $group->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                                    <form action="{{ route('groups.destroy', $group->id) }}" style="display: inline;" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <td colspan="7">No data available in table</td>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $groups->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

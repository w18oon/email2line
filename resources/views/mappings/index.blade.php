@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        All {{ Str::ucfirst($base_route) }}
                        <div class="ml-auto">
                            <a href="{{ route($base_route  . '.create') }}" class="btn btn-outline-secondary btn-sm">Create {{ Str::singular($base_route) }}</a>
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
                                <th>E-Mail Subject</th>
                                <th>Group Name</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mappings as $mapping)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mapping->subject }}</td>
                                <td>{{ $mapping->group->name }}</td>
                                <td>{{ $mapping->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route($base_route  . '.edit', $mapping->id) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                                    <form action="{{ route($base_route  . '.destroy', $mapping->id) }}" style="display: inline;" method="post">
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
                    {{ $mappings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

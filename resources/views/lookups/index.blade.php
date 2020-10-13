@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        All Lookups
                        <div class="ml-auto">
                            <a href="{{ route('lookups.create') }}" class="btn btn-outline-secondary btn-sm">Create Lookup</a>
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
                                <th>Subject</th>
                                <th>Line Access Token</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lookups as $lookup)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lookup->subject }}</td>
                                <td>{{ Str::limit($lookup->token, 10, '...') }}</td>
                                <td>{{ $lookup->remarks }}</td>
                                <td>
                                    @if($lookup->status)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $lookup->created_at }}</td>
                                <td>
                                    <a href="{{ route('lookups.edit', $lookup->id) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                                    <form action="{{ route('lookups.destroy', $lookup->id) }}" style="display: inline;" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <td colspan="7">No data available in table</td>
                            @endforelse
                            {{ $lookups->links() }}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

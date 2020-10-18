@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        All Users
                        <div class="ml-auto">
                            <a href="{{ route('users.create') }}" class="btn btn-outline-secondary btn-sm">Create user</a>
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
                                <th>Name</th>
                                <th>E-Mail Address</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-dark {{ (Auth::user()->id != 1 && $user->id == 1)? 'disabled': null }}">Edit</a>
                                    <a href="{{ route('user-change-password', $user->id) }}" class="btn btn-sm btn-outline-dark {{ (Auth::user()->id != 1 && $user->id == 1)? 'disabled': null }}">Change Password</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" style="display: inline;" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')" {{ ($user->id == 1)? 'disabled': null }}>Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <td colspan="7">No data available in table</td>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

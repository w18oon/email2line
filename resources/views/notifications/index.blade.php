@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        All Notifications
                        <div class="ml-auto">
                            <a href="{{ route('search-notification') }}" class="btn btn-outline-secondary btn-sm">Search</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notifications as $notification)
                            <tr>
                                <td>{{ $notification->lookup->subject }}</td>
                                {{-- <td>{{ $notification->status }}</td> --}}
                                <td>                                    
                                    <span class="badge badge-{{ $notification->status == 200? 'success': 'secondary'}}">{{ $notification->status }}</span>
                                </td>
                                <td>{{ $notification->created_at }}</td>
                            </tr>
                            @empty
                                <td colspan="7">No data available in table</td>
                            @endforelse
                            {{-- {{ $notifications->links() }} --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

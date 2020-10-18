@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-item-center">
                        Report as of {{ $log_date }}
                        <div class="ml-auto">
                            <a href="{{ route($base_route  . '.index') }}" class="btn btn-outline-secondary btn-sm">Back to all {{ Str::singular($base_route) }}</a>
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
                                <th>Group Name</th>
                                <th>Subject</th>
                                <th>Send Status</th>
                                <th>Send At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->name }}</td>
                                <td>{{ $log->subject }}</td>
                                <td>
                                    @if($log->line_notify_flag)
                                    <span class="badge badge-success">Send</span>
                                    @else
                                    <span class="badge badge-secondary">Not Send</span>
                                    @endif
                                </td>
                                <td>{{ $log->created_at }}</td>
                            </tr>
                            @empty
                                <td colspan="4">No data available in table</td>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

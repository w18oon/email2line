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
                            <a href="{{ route('reports.search') }}" class="btn btn-outline-secondary btn-sm">Search</a>
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
                                <th>Total Nofity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->name }}</td>
                                <td>{{ $log->subject }}</td>
                                <td>{{ $log->log_count }}</td>
                                <td>
                                    <a href="{{ route('reports.show', [$log_date, $log->mapping_id]) }}" class="btn btn-sm btn-outline-dark">Detail</a>
                                </td>
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

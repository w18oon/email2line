<?php

namespace App\Http\Controllers;

use App\Group;
use App\Mapping;
use App\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    const BASE_ROUTE = 'reports';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $logs = Log::with('mappings')->get();
        $logs = \DB::table('logs')
            ->join('mappings', 'mappings.id', '=', 'logs.mapping_id')
            ->join('groups', 'groups.id', '=', 'mappings.group_id')
            ->select(DB::raw('groups.name, mappings.group_id, mappings.subject, logs.mapping_id, count(*) as log_count'))
            ->whereDate('logs.created_at', Carbon::today())
            ->groupByRaw('groups.name, mappings.group_id, mappings.subject, logs.mapping_id')
            ->paginate(10);
        return view(self::BASE_ROUTE . '.index', [
            'logs' => $logs,
            'log_date' => Carbon::parse(Carbon::today())->toDateString(),
            'base_route' => self::BASE_ROUTE,
        ]);
    }

    public function search()
    {
        $groups = Group::get();
        return view(self::BASE_ROUTE . '.search', [
            'groups' => $groups,
            'base_route' => self::BASE_ROUTE,
        ]);
    }

    public function result(Request $request)
    {
        $log_date = $request->created;
        $logs = \DB::table('logs')
            ->join('mappings', 'mappings.id', '=', 'logs.mapping_id')
            ->join('groups', 'groups.id', '=', 'mappings.group_id')
            ->select(DB::raw('groups.name, mappings.group_id, mappings.subject, logs.mapping_id, count(*) as log_count'))
            ->whereDate('logs.created_at', $log_date)
            ->where('groups.id', $request->group)
            ->groupByRaw('groups.name, mappings.group_id, mappings.subject, logs.mapping_id')
            ->paginate(10);
        return view(self::BASE_ROUTE . '.index', [
            'logs' => $logs,
            'log_date' => $log_date,
            'base_route' => self::BASE_ROUTE,
        ]);
    }

    public function show($date, $mapping_id)
    {
        $logs = \DB::table('logs')
        ->join('mappings', 'mappings.id', '=', 'logs.mapping_id')
        ->join('groups', 'groups.id', '=', 'mappings.group_id')
        ->select(DB::raw('groups.name, mappings.subject, logs.line_notify_flag, logs.created_at'))
        ->whereDate('logs.created_at', $date)
        ->where('mappings.id', $mapping_id)
        ->paginate(10);

        return view(self::BASE_ROUTE . '.show', [
            'logs' => $logs,
            'log_date' => $date,
            'base_route' => self::BASE_ROUTE,
        ]);
    }
}

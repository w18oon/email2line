<?php

namespace App\Http\Controllers;

use App\Lookup;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::with('lookup')->whereDate('created_at', '>=', Carbon::today()->add(-7, 'days'))->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    public function search()
    {
        $lookups = Lookup::get();
        return view('notifications.search', compact('lookups'));
    }

    public function result(Request $request)
    {
        $conditions = [];
        array_push($conditions, ['lookup_id', '=', $request->subject]);
        if ($request->created) {
            array_push($conditions, ['created_at', '>=', $request->created . ' 00:00:00']);
            array_push($conditions, ['created_at', '<', $request->created . ' 23:59:59']);
        }
        $notifications = Notification::with('lookup')->where($conditions)->get();
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}

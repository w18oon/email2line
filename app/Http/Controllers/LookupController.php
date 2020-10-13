<?php

namespace App\Http\Controllers;

use App\Lookup;
use App\Http\Requests\LookupRequest;
use Illuminate\Http\Request;

class LookupController extends Controller
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
        $lookups = Lookup::paginate(10);
        return view('lookups.index', compact('lookups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lookup = new Lookup();
        return view('lookups.create', compact('lookup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LookupRequest $request)
    {
        Lookup::create($request->only('subject', 'token', 'remarks'));
        return redirect()->route('lookups.index')->with('success','Lookup has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Lookup $lookup)
    {
        return view('lookups.edit', compact('lookup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LookupRequest $request, Lookup $lookup)
    {
        $lookup->update($request->only('subject', 'token', 'remarks'));
        return redirect()->route('lookups.index')->with('success','Lookup has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lookup $lookup)
    {
        $lookup->delete();
        return redirect()->route('lookups.index')->with('success','Lookup has been deleted');
    }
}

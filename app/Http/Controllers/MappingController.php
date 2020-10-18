<?php

namespace App\Http\Controllers;

use App\Group;
use App\Mapping;
use App\Http\Requests\MappingRequest;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    const BASE_ROUTE = 'mappings';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mappings = Mapping::with('group')->paginate(10);
        return view(self::BASE_ROUTE . '.index', [
            'mappings' => $mappings,
            'base_route' => self::BASE_ROUTE
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mapping = new Mapping();
        $groups = Group::get();
        return view(self::BASE_ROUTE . '.create', [
            'groups' => $groups, 
            'mapping' => $mapping, 
            'base_route' => self::BASE_ROUTE
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MappingRequest $request)
    {
        $group = Group::find($request->group_id);
        $group->mappings()->create($request->only('subject'));
        return redirect()->route(self::BASE_ROUTE . '.index')->with('success', 'Mapping has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mapping  $mapping
     * @return \Illuminate\Http\Response
     */
    public function show(Mapping $mapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mapping  $mapping
     * @return \Illuminate\Http\Response
     */
    public function edit(Mapping $mapping)
    {
        $groups = Group::get();
        return view(self::BASE_ROUTE . '.edit', [
            'groups' => $groups, 
            'mapping' => $mapping, 
            'base_route' => self::BASE_ROUTE
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mapping  $mapping
     * @return \Illuminate\Http\Response
     */
    public function update(MappingRequest $request, Mapping $mapping)
    {
        $group = Group::find($request->group_id);
        $group->mappings()->where('id', $mapping->id)->update($request->only('subject'));
        return redirect()->route(self::BASE_ROUTE . '.index')->with('success', 'Mapping has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mapping  $mapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mapping $mapping)
    {
        $mapping->delete();
        return redirect()->route(self::BASE_ROUTE . '.index')->with('success', 'Mapping has been deleted');
    }
}

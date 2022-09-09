<?php

namespace App\Http\Controllers;

use App\Http\Resources\MaintenanceTypeResource;
use App\Models\MaintenanceType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MaintenanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $maintenance_types = MaintenanceType::all();
        return MaintenanceTypeResource::collection($maintenance_types);
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
     * @param  \App\Models\MaintenanceType  $maintenanceType
     * @return \Illuminate\Http\Response
     */
    public function show(MaintenanceType $maintenanceType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaintenanceType  $maintenanceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenanceType $maintenanceType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaintenanceType  $maintenanceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenanceType $maintenanceType)
    {
        //
    }
}

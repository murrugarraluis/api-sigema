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
     * @param MaintenanceType $maintenanceType
     * @return MaintenanceTypeResource
     */
    public function show(MaintenanceType $maintenanceType): MaintenanceTypeResource
    {
        return new MaintenanceTypeResource($maintenanceType);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param MaintenanceType $maintenanceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenanceType $maintenanceType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MaintenanceType $maintenanceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenanceType $maintenanceType)
    {
        //
    }
}

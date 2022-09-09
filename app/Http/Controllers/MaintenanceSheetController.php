<?php

namespace App\Http\Controllers;

use App\Http\Resources\MaintenanceSheetResource;
use App\Models\MaintenanceSheet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MaintenanceSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $maintenance_sheets = MaintenanceSheet::all();
        return MaintenanceSheetResource::collection($maintenance_sheets);
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
     * @param  \App\Models\MaintenanceSheet  $maintenanceSheet
     * @return \Illuminate\Http\Response
     */
    public function show(MaintenanceSheet $maintenanceSheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaintenanceSheet  $maintenanceSheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenanceSheet $maintenanceSheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaintenanceSheet  $maintenanceSheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenanceSheet $maintenanceSheet)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\MaintenanceSheetResource;
use App\Models\MaintenanceSheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

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
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param MaintenanceSheet $maintenanceSheet
     * @return MaintenanceSheetResource
     */
    public function show(MaintenanceSheet $maintenanceSheet): MaintenanceSheetResource
    {
//        dd(new MaintenanceSheetResource($maintenanceSheet));
        return new MaintenanceSheetResource($maintenanceSheet);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param MaintenanceSheet $maintenanceSheet
     * @return Response
     */
    public function update(Request $request, MaintenanceSheet $maintenanceSheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MaintenanceSheet $maintenanceSheet
     * @return JsonResponse
     */
    public function destroy(MaintenanceSheet $maintenanceSheet): JsonResponse
    {
        $maintenanceSheet->delete();
        return response()->json(['message'=>'Maintenance Sheet removed.'],200);
    }
}

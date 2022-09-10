<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkingSheetDetailResource;
use App\Http\Resources\WorkingSheetResource;
use App\Models\WorkingSheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WorkingSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $working_sheets = WorkingSheet::all();
        return WorkingSheetResource::collection($working_sheets);
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
     * @param WorkingSheet $workingSheet
     * @return WorkingSheetDetailResource
     */
    public function show(WorkingSheet $workingSheet): WorkingSheetDetailResource
    {
        return new WorkingSheetDetailResource($workingSheet);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param WorkingSheet $workingSheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkingSheet $workingSheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkingSheet $workingSheet
     * @return JsonResponse
     */
    public function destroy(WorkingSheet $workingSheet): JsonResponse
    {
        $workingSheet->delete();
        return response()->json(['message'=>'Working Sheet removed.'],200);
    }
}

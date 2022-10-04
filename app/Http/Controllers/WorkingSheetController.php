<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkStartRequest;
use App\Http\Resources\WorkingSheetDetailResource;
use App\Http\Resources\WorkingSheetResource;
use App\Models\WorkingSheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class WorkingSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $working_sheets = WorkingSheet::all()->sortByDesc('created_at');
        return WorkingSheetResource::collection($working_sheets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function start(WorkStartRequest $request)
    {
        DB::beginTransaction();
        try {
//            CREATE SUPPLIER
            $working_sheet = WorkingSheet::create([
                'machine_id' => $request->machine["id"],
                'date_start' => date('Y-m-d'),
                'description' => $request->description,
                'is_open' => true
            ]);
            $working_sheet->working_hours()->create([
                'date_time_start' => date('Y-m-d H:i:s')
            ]);
            DB::commit();
            return (new WorkingSheetDetailResource($working_sheet))
                ->additional(['message' => 'Work started.'])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            DB::rollback();
            throw new BadRequestException($e->getMessage());
        }
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
     * @param \Illuminate\Http\Request $request
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
        return response()->json(['message' => 'Working Sheet removed.'], 200);
    }
}

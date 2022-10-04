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
                'date' => date('Y-m-d'),
                'description' => $request->description,
                'is_open' => true
            ]);
            $this->restart($working_sheet);
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

    public function pause(WorkingSheet $workingSheet)
    {
        DB::beginTransaction();
        try {
            $last_working_hour = $workingSheet->working_hours()->orderBy('created_at', 'desc')->first();
            if (!$last_working_hour->date_time_end) {
                $last_working_hour->update([
                    'date_time_end' => date('Y-m-d H:i:s')
                ]);
            }
            DB::commit();
            return (new WorkingSheetDetailResource($workingSheet))
                ->additional(['message' => 'Work paused.']);
        } catch (\Exception $e) {
            DB::rollback();
            throw new BadRequestException($e->getMessage());
        }
    }

    public function restart(WorkingSheet $workingSheet)
    {
        DB::beginTransaction();
        try {
            $workingSheet->working_hours()->create([
                'date_time_start' => date('Y-m-d H:i:s')
            ]);
            DB::commit();
            return (new WorkingSheetDetailResource($workingSheet))
                ->additional(['message' => 'Work restarted.']);
        } catch (\Exception $e) {
            DB::rollback();
            throw new BadRequestException($e->getMessage());
        }
    }

    public function stop(WorkingSheet $workingSheet)
    {
        DB::beginTransaction();
        try {
            $this->pause($workingSheet);
            $workingSheet->update([
                'is_open' => false
            ]);
            DB::commit();
            return (new WorkingSheetDetailResource($workingSheet))
                ->additional(['message' => 'Work stopped.']);
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

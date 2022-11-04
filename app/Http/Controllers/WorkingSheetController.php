<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkStartRequest;
use App\Http\Requests\WorkUpdateRequest;
use App\Http\Resources\WorkingSheetDetailResource;
use App\Http\Resources\WorkingSheetResource;
use App\Models\WorkingSheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class WorkingSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $working_sheets = WorkingSheet::all()->sortByDesc('created_at');
        if ($request->start_date && $request->end_date) {
            $working_sheets = WorkingSheet::whereDate('date', '>=', $request->start_date)->whereDate('date', '<=', $request->end_date)
                ->get()->sortByDesc('created_at');
        }
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
            $working_sheet = WorkingSheet::create([
                'machine_id' => $request->machine["id"],
                'date' => $request->date,
                'description' => $request->description,
                'is_open' => true
            ]);
            $request_restart = new WorkUpdateRequest();
            $request_restart->merge(['date' => $request->date]);
            $this->restart($request_restart, $working_sheet);
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

    public function pause(WorkUpdateRequest $request, WorkingSheet $workingSheet)
    {
        DB::beginTransaction();
        try {
//            dd($request->date);
            $last_working_hour = $workingSheet->working_hours()->orderBy('created_at', 'desc')->first();
            if (!$last_working_hour->date_time_end) {
                $last_working_hour->update([
                    'date_time_end' => $request->date
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

    public function restart(WorkUpdateRequest $request, WorkingSheet $workingSheet)
    {
//        dd($request->date);
        DB::beginTransaction();
        try {
            $workingSheet->working_hours()->create([
                'date_time_start' => $request->date
            ]);
            DB::commit();
            return (new WorkingSheetDetailResource($workingSheet))
                ->additional(['message' => 'Work restarted.']);
        } catch (\Exception $e) {
            DB::rollback();
            throw new BadRequestException($e->getMessage());
        }
    }

    public function stop(WorkUpdateRequest $request, WorkingSheet $workingSheet)
    {
        DB::beginTransaction();
        try {
            $this->pause($request, $workingSheet);
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
    public function show_pdf(WorkingSheet $workingSheet)
    {
        $data = $this->show($workingSheet)->jsonSerialize();
//        dd($data);
        $pdf = \PDF::loadView('work-one-report', compact('data'));
        $pdf->setPaper('A4');
        return $pdf->download();

        $name_file = Str::uuid()->toString();
        $path = 'public/reports/' . $name_file . '.pdf';
        Storage::put($path, $pdf->output());
        $path = (substr($path, 7, strlen($path)));

        return [
            'path' => $path
        ];

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

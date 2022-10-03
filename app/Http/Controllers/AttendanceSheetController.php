<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceSheetDetailResource;
use App\Http\Resources\AttendanceSheetResource;
use App\Http\Resources\EmployeeResource;
use App\Models\AttendanceSheet;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AttendanceSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $attendance_sheets = AttendanceSheet::all()->sortByDesc('created_at');
        return AttendanceSheetResource::collection($attendance_sheets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|object
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
//          CREATE
            $attendance_sheet = AttendanceSheet::create([
                'date' => date('Y-m-d'),
                'responsible' => Auth()->user()->employee()->first()->name . " " . Auth()->user()->employee()->first()->lastname,
                'status' => true,
            ]);
            $employees = Employee::all();
            $attendance_sheet->employees()->attach($employees);
            DB::commit();
            return (new AttendanceSheetDetailResource($attendance_sheet))
                ->additional(['message' => 'Attendance Sheet created.'])
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
     * @param AttendanceSheet $attendanceSheet
     * @return AttendanceSheetDetailResource
     */
    public function show(AttendanceSheet $attendanceSheet): AttendanceSheetDetailResource
    {
        return new AttendanceSheetDetailResource($attendanceSheet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AttendanceSheet $attendanceSheet
     * @return Response
     */
    public function update(Request $request, AttendanceSheet $attendanceSheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AttendanceSheet $attendanceSheet
     * @return JsonResponse
     */
    public function destroy(AttendanceSheet $attendanceSheet): JsonResponse
    {
        $attendanceSheet->delete();
        return response()->json(['message' => 'Attendance Sheet removed.'], 200);
    }
}

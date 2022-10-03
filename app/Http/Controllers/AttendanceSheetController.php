<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceUpdateRequest;
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
                'is_open' => true,
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
     * @param AttendanceUpdateRequest $request
     * @param AttendanceSheet $attendanceSheet
     * @return AttendanceSheetDetailResource|JsonResponse|object
     */
    public function update(AttendanceUpdateRequest $request, AttendanceSheet $attendanceSheet)
    {
        DB::beginTransaction();
        try {
            if ($attendanceSheet->date !== date('Y-m-d')) return response()->json(['message' => 'cannot update a past attendance sheet.'])->setStatusCode(400);
            if (!$attendanceSheet->is_open) return response()->json(['message' => 'cannot update a closed attendance sheet.'])->setStatusCode(400);
            if ($request->employees) {
                $employees = [];
                array_map(function ($employee) use (&$employees) {
                    $employee_id = $employee['id'];
                    $check_in = array_key_exists('check_in', $employee) ? $employee['check_in'] : null;
                    $check_out = array_key_exists('check_out', $employee) ? $employee['check_out'] : null;
                    $attendance = array_key_exists('check_in', $employee) && $employee['check_in'];
                    $employees[$employee_id] = ["check_in" => $check_in, "check_out" => $check_out, "attendance" => $attendance];
                }, $request->employees);
                $attendanceSheet->employees()->sync($employees);
            }
            if ($request->has('is_open')) {
                $attendanceSheet->update(['is_open' => $request->is_open]);
            }
            DB::commit();
            return (new AttendanceSheetDetailResource($attendanceSheet))
                ->additional(['message' => 'Attendance Sheet updated.']);
        } catch (\Exception $e) {
            DB::rollback();
            throw new BadRequestException($e->getMessage());
        }
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

<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceSheetDetailResource;
use App\Http\Resources\AttendanceSheetResource;
use App\Models\AttendanceSheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
     * @param  \Illuminate\Http\Request  $request
     * @param AttendanceSheet $attendanceSheet
     * @return \Illuminate\Http\Response
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
        return response()->json(['message'=>'Attendance Sheet removed.'],200);
    }
}

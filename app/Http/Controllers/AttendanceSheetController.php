<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceSheetResource;
use App\Models\AttendanceSheet;
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
        $attendance_sheets = AttendanceSheet::all();
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
     * @return AttendanceSheetResource
     */
    public function show(AttendanceSheet $attendanceSheet): AttendanceSheetResource
    {
        return new AttendanceSheetResource($attendanceSheet);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendanceSheet $attendanceSheet)
    {
        //
    }
}

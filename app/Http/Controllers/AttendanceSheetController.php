<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceStoreRequest;
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
	public function index(Request $request): AnonymousResourceCollection
	{
		$attendance_sheets = AttendanceSheet::all()->sortByDesc('created_at');
		if ($request->start_date && $request->end_date) {
			//            $attendance_sheets = AttendanceSheet::whereDateBetween('date', [$request->start_date, $request->end_date])
			//                ->get()->sortByDesc('created_at');
			$attendance_sheets = AttendanceSheet::whereDate('date', '>=', $request->start_date)->whereDate('date', '<=', $request->end_date)
				->get()->sortByDesc('created_at');
		}
		return AttendanceSheetResource::collection($attendance_sheets);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return JsonResponse|object
	 */
	public function store(AttendanceStoreRequest $request)
	{
		DB::beginTransaction();
		try {
			//          CREATE
			$count_attendance_sheet = AttendanceSheet::whereDate('date', date('Y-m-d'))->get()->count();
			if ($count_attendance_sheet > 1) return response()->json(['message' => 'cannot create more than two records per day.'])->setStatusCode(400);
			$attendance_sheet = AttendanceSheet::create([
				'date' => date('Y-m-d H:i:s'),
				'responsible' => Auth()->user()->employee()->first()->name . " " . Auth()->user()->employee()->first()->lastname,
				'is_open' => true,
			]);

			$employees = [];
			array_map(function ($employee) use (&$employees) {
				$employees[] = $employee['id'];
			}, $request->employees);
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
			if (!$attendanceSheet->is_open) return response()->json(['message' => 'cannot update a closed attendance sheet.'])->setStatusCode(400);
			if ($request->has('is_open')) {
				$attendanceSheet->update(['is_open' => $request->is_open]);
			}
			if ($request->employees) {
				if (date('Y-m-d', strtotime($attendanceSheet->date)) !== date('Y-m-d')) return response()->json(['message' => 'cannot update a past attendance sheet.'])->setStatusCode(400);
				$employees = [];
				array_map(function ($employee) use (&$employees) {
					$employee_id = $employee['id'];
					$check_in = array_key_exists('check_in', $employee) ? $employee['check_in'] : null;
					$check_out = array_key_exists('check_out', $employee) ? $employee['check_out'] : null;
					$attendance = $employee['attendance'];
					$missed_reason = array_key_exists('missed_reason', $employee) ? $employee['missed_reason'] : null;;
					$missed_description = array_key_exists('missed_description', $employee) ? $employee['missed_description'] : null;;

					$employees[$employee_id] = [
						"check_in" => $check_in,
						"check_out" => $check_out,
						"attendance" => $attendance,
						"missed_reason" => $missed_reason,
						"missed_description" => $missed_description,

					];
				}, $request->employees);
				$attendanceSheet->employees()->sync($employees);
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

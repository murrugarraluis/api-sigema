<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\SafeCredentialsResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $employees = Employee::all();
        return EmployeeResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Generate credentials Employee.
     *
     * @param Employee $employee
     * @return SafeCredentialsResource
     */
    public function generate_safe_credentials(Employee $employee): SafeCredentialsResource
    {
        $username = substr(strtolower($employee->name), 0, 1) . strtolower($employee->lastname);
        $count_users = User::where('email', 'like', '%' . $username . '%')->count();
        if ($count_users > 0) $username = $username . $count_users;

        $email = $username . "@jextecnologies.com";
        $password = $employee->document_number;
        $credentials = [
            "email" => $email,
            "password" => $password
        ];

        return (new SafeCredentialsResource($credentials))->additional(['message' => 'Safe credentials generated.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return EmployeeResource
     */
    public function show(Employee $employee): EmployeeResource
    {
        return new EmployeeResource($employee);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Employee $employee
     * @return Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return JsonResponse
     */
    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();
        return response()->json(['message' => 'Employee removed.'], 200);
    }
}

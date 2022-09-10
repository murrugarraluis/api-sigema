<?php

namespace App\Http\Controllers;

use App\Http\Resources\MachineResource;
use App\Models\Machine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $machines = Machine::all();
        return MachineResource::collection($machines);
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
     * @param Machine $machine
     * @return MachineResource
     */
    public function show(Machine $machine): MachineResource
    {
        return new MachineResource($machine);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Machine $machine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Machine $machine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Machine $machine
     * @return JsonResponse
     */
    public function destroy(Machine $machine): JsonResponse
    {
        $machine->delete();
        return response()->json(['message'=>'Machine removed.'],200);
    }
}

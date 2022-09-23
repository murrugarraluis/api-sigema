<?php

namespace App\Http\Controllers;

use App\Http\Requests\MachineRequest;
use App\Http\Requests\MachineUpdateRequest;
use App\Http\Resources\MachineResource;
use App\Http\Resources\MachinetDetailResource;
use App\Models\Machine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $machines = Machine::all()->sortByDesc('created_at');
        return MachineResource::collection($machines);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|Response|object
     */
    public function store(MachineRequest $request)
    {
        DB::beginTransaction();
        try {
//          CREATE MACHINE
            $machine = Machine::create($request->except(['articles', 'image']));
            $this->addImage($machine,$request->image);
//            ATTACH ARTICLES
            $articles = [];
            array_map(function ($article) use (&$articles) {
                $article_id = $article['id'];
                $articles[] = $article_id;
            }, $request->articles);
            $machine->articles()->attach($articles);
            DB::commit();
            return (new MachinetDetailResource($machine))
                ->additional(['message' => 'Machine created.'])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            DB::rollback();
//            dd($e->getMessage());
            throw new BadRequestException($e->getMessage());
        }
    }
    public function addImage(Machine $machine,$path){
        if ($path){
            $machine->image()->create(['path'=>$path]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Machine $machine
     * @return MachinetDetailResource
     */
    public function show(Machine $machine): MachinetDetailResource
    {
        return new MachinetDetailResource($machine);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param MachineUpdateRequest $request
     * @param Machine $machine
     * @return MachinetDetailResource
     */
    public function update(MachineUpdateRequest $request, Machine $machine): MachinetDetailResource
    {
        DB::beginTransaction();
        try {
//          UPDATE MACHINE
            $machine->update($request->except(['articles', 'image']));
//            ATTACH ARTICLES
            $articles = [];
            array_map(function ($article) use (&$articles) {
                $article_id = $article['id'];
                $articles[] = $article_id;
            }, $request->articles);
            $machine->articles()->sync($articles);
            DB::commit();
            return (new MachinetDetailResource($machine))->additional(['message' => 'Machine updated.']);
        } catch (\Exception $e) {
            DB::rollback();
//            dd($e->getMessage());
            throw new BadRequestException($e->getMessage());
        }
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
        return response()->json(['message' => 'Machine removed.'], 200);
    }
}

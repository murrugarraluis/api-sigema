<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceSheetStoreRequest;
use App\Http\Resources\MaintenanceSheetDetailResource;
use App\Http\Resources\MaintenanceSheetResource;
use App\Models\MaintenanceSheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class MaintenanceSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $maintenance_sheets = MaintenanceSheet::all()->sortByDesc('created_at');
        return MaintenanceSheetResource::collection($maintenance_sheets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|Response|object
     */
    public function store(MaintenanceSheetStoreRequest $request)
    {
        DB::beginTransaction();
        try {
//          CREATE
            $maintenance_sheet = MaintenanceSheet::create([
                "date" => $request->date,
                "responsible" => $request->responsible,
                "technical" => $request->technical,
                "description" => $request->description,
                'supplier_id' => $request->supplier["id"],
                'maintenance_type_id' => $request->maintenance_type["id"],
                'machine_id' => $request->machine["id"],
            ]);
            $details = [];
            $item = 1;
            array_map(function ($detail) use (&$details, &$item) {
                $new = [
                    "article_id" => array_key_exists('article', $detail) ? $detail['article']['id'] : null,
                    "description" => $detail['description'],
                    "price" => $detail['price'],
                    "quantity" => $detail['quantity'],
                    "item" => $item,
                ];
                $details[] = $new;
                $item++;
            }, $request->detail);
            $maintenance_sheet->maintenance_sheet_details()->createMany($details);

            DB::commit();
            return (new MaintenanceSheetDetailResource($maintenance_sheet))
                ->additional(['message' => 'Maintenance Sheet created.'])
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
     * @param MaintenanceSheet $maintenanceSheet
     * @return MaintenanceSheetDetailResource
     */
    public function show(MaintenanceSheet $maintenanceSheet): MaintenanceSheetDetailResource
    {
//        dd(new MaintenanceSheetResource($maintenanceSheet));
        return new MaintenanceSheetDetailResource($maintenanceSheet);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param MaintenanceSheet $maintenanceSheet
     * @return Response
     */
    public function update(Request $request, MaintenanceSheet $maintenanceSheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MaintenanceSheet $maintenanceSheet
     * @return JsonResponse
     */
    public function destroy(MaintenanceSheet $maintenanceSheet): JsonResponse
    {
        $maintenanceSheet->delete();
        return response()->json(['message' => 'Maintenance Sheet removed.'], 200);
    }
}

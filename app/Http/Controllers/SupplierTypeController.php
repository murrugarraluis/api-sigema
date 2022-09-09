<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\SupplierTypeResource;
use App\Models\SupplierType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SupplierTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $supplier_types = SupplierType::all();
        return SupplierTypeResource::collection($supplier_types);
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
     * @param  \App\Models\SupplierType  $supplierType
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierType $supplierType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierType  $supplierType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierType $supplierType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierType  $supplierType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierType $supplierType)
    {
        //
    }
}

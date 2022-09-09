<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleTypeResource;
use App\Models\Article;
use App\Models\ArticleType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $article_types = ArticleType::all();
        return ArticleTypeResource::collection($article_types);
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
     * @param ArticleType $articleType
     * @return ArticleTypeResource
     */
    public function show(ArticleType $articleType): ArticleTypeResource
    {
        return new ArticleTypeResource($articleType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param ArticleType $articleType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticleType $articleType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ArticleType $articleType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleType $articleType)
    {
        //
    }
}

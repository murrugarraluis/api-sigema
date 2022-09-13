<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleTypeRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleTypeResource;
use App\Models\Article;
use App\Models\ArticleType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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
     * @param ArticleTypeRequest $request
     * @return JsonResponse|object
     */
    public function store(ArticleTypeRequest $request)
    {
        DB::beginTransaction();
        try {
//          CREATE ARTICLE TYPE
            $article_type = ArticleType::create(['name' => $request->name]);
            DB::commit();
            return (new ArticleTypeResource($article_type))
                ->additional(['message' => 'Article Type created.'])
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
     * @param \Illuminate\Http\Request $request
     * @param ArticleType $articleType
     * @return Response
     */
    public function update(Request $request, ArticleType $articleType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ArticleType $articleType
     * @return JsonResponse
     */
    public function destroy(ArticleType $articleType): JsonResponse
    {
        $articleType->delete();
        return response()->json(['message' => 'Article Type removed.'], 200);
    }
}

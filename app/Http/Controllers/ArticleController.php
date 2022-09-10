<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleDetailResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Collection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $articles = Article::all();
        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return JsonResponse|object|string
     */
    public function store(ArticleRequest $request)
    {
//        TODO:REFACTOR
        DB::beginTransaction();
        try {
//            CREATE ARTICLE
            $article = Article::create([
                'name' => $request->name,
                'brand' => $request->brand,
                'model' => $request->model,
                'quantity' => $request->quantity,
                'article_type_id' => $request->article_type["id"],
            ]);
//            ATTACH SUPPLIERS
            $suppliers = [];
            array_map(function ($supplier) use ($article,&$suppliers) {
                $supplier_id = $supplier['id'];
                $price = $supplier['price'];
                $suppliers[$supplier_id]= ["price" => $price];
            }, $request->suppliers);

            $article->suppliers()->attach($suppliers);

            DB::commit();
            return (new ArticleDetailResource($article))
                ->additional(['message' => 'Article created.'])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            DB::rollback();
//            dd($e->getMessage());
            throw new BadRequestException($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return ArticleDetailResource
     */
    public function show(Article $article): ArticleDetailResource
    {
        return new ArticleDetailResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**A
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Article $article): JsonResponse
    {
        $article->delete();
        return response()->json(['message' => 'Article removed.'], 200);
    }
}

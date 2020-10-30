<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Psy\Util\Str;

class ArticleController extends Controller
{
    public function show(Article $article)
    {
        return ArticleResource::make($article);
    }


    public function index()
    {
        $sortFileds = (\request('sort')) ? \Str::of(\request('sort'))->explode(',') : [];  // Se convierte a array

        // Permite exponer el query
        $articleQuery = Article::query();

        foreach ($sortFileds as $sortFiled){
            $directionOrder = 'asc';
            // Comprobando si el parametro sort inicia en el caracter -
            if (\Str::of($sortFiled)->startsWith('-')) {
                $directionOrder = 'desc';
                // Le removemos el primer caracter
                $sortFiled = \Str::of($sortFiled)->substr(1);
            }

            // Acomulara para cada iteracion, el orden y lo armara correctamente
            $articleQuery->orderBy($sortFiled, $directionOrder);
        }


        // $articles = Article::all();
        // Ordenamos por lo que se pase por parametro en get sort
        // $articles = Article::orderBy($sortFiled, $directionOrder)->get();
        // Ejecuta el query usando el oder dinamico y con get obtiene los registros
        $articles = $articleQuery->get();
        // Usamos una coleccion de Articles, que iterara para cada article enviado
        return ArticleCollection::make($articles);

        /*return response()->json(
            [
                'data' => Article::all()->map(function ($article) {
                    return [
                        'type' => 'articles',
                        'id' => (string)$article->getRouteKey(),
                        'attributes' => [
                            'title' => $article->title,
                            'slug' => $article->slug,
                            'content' => $article->content
                        ],
                        'links' => [
                            'self' => url('api/v1/articles/' . $article->getRouteKey())
                        ]
                    ];
                })


            ]
        );*/
    }
}

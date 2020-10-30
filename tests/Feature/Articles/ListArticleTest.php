<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListArticleTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function can_fetch_single_article()
    {

        // Desabilita el manejo de exepciones para ver mas conreto el error
        // $this->withoutExceptionHandling();

        $article = factory(Article::class)->create();

        $response = $this->getJson(route('api.v1.articles.show', $article));

        // Verifica que contenga los datos del mock, sin validar tipo de dato
        // $response->assertJson([]);
        // Verifica que contenga el siguiente mock la respuesta extatamente
        $response->assertExactJson(
            [
                'data' => [
                    'type' => 'articles',
                    'id' => (string)$article->getRouteKey(),
                    'attributes' => [
                        'title' => $article->title,
                        'slug' => $article->slug,
                        'content' => $article->content
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $article)
                    ]
                ]
            ]
        );
    }

    /**
     * @test
     */
    public function can_fetch_all_article()
    {

        // Desabilita el manejo de exepciones para ver mas conreto el error
        // $this->withoutExceptionHandling();

        $articles = factory(Article::class, 1)->create();

        $response = $this->getJson(route('api.v1.articles.index'));


        $response_mock = [];
        foreach ($articles as $article) {
            $article_mock = [
                'type' => 'articles',
                'id' => (string)$article->getRouteKey(),
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article->getRouteKey())
                ]
            ];
            array_push($response_mock, $article_mock);
        }

        $response_mock = ['data' => $response_mock];
        $response_mock['links'] = ['self' => route('api.v1.articles.index')];
        $response_mock['meta'] = ['articles_count' => $articles->count()];

        // Verifica que contenga el siguiente mock la respuesta extatamente
        $response->assertJson(
            $response_mock
        );
    }
}

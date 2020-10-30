<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortArticlesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_sort_articles_by_title_asc()
    {
        factory(Article::class)->create(['title' => 'C title']);
        factory(Article::class)->create(['title' => 'A title']);
        factory(Article::class)->create(['title' => 'B title']);

        $url = route('api.v1.articles.index', ['sort' => 'title']);
        // Permite verificar que encuentre los parametros pasados en ese mismo orden
        $this->getJson($url)->assertSeeInOrder([
            'A title',
            'B title',
            'C title'
        ]);
    }


    /**
     * @test
     */
    public function it_can_sort_articles_by_title_desc()
    {
        factory(Article::class)->create(['title' => 'C title']);
        factory(Article::class)->create(['title' => 'A title']);
        factory(Article::class)->create(['title' => 'B title']);

        $url = route('api.v1.articles.index', ['sort' => '-title']);  // ?sort=-title   // orden desencendente
        // Permite verificar que encuentre los parametros pasados en ese mismo orden
        $this->getJson($url)->assertSeeInOrder([
            'C title',
            'B title',
            'A title'
        ]);
    }

    /**
     * @test
     */
    public function it_can_sort_articles_by_title_and_content()
    {
        factory(Article::class)->create(['title' => 'C title', 'content' => 'A Contenido']);
        factory(Article::class)->create(['title' => 'A title', 'content' => 'B Contenido']);
        factory(Article::class)->create(['title' => 'B title', 'content' => 'C Contenido']);

        $url = route('api.v1.articles.index') . '?sort=title,content';  // ?sort=-title   // orden desencendente

        // Permite verificar que encuentre los parametros pasados en ese mismo orden
        $this->getJson($url)->assertSeeInOrder([
            'A title',
            'B title',
            'C title'
        ]);
    }
}

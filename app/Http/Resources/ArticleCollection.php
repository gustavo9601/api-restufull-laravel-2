<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        // $this->collection  // Hace referencia a la variable que se pasa por parametro al llamar el recurso
        return [
            // Se envia al article resource, que pasandole como coleection sabe que debe iterara sobre cada article enviado y retornar la estructura
            'data' => ArticleResource::collection($this->collection),
            'links' => [
                'self' => route('api.v1.articles.index')
            ],
            'meta' => [
                'articles_count' => $this->collection->count()
            ]
        ];
    }
}

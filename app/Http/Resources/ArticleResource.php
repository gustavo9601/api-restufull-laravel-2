<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function toArray($request)
    {

        // $this->resource
        // Usa el article que se pasa por parametro al llamar el recurso
        // Al extender de JsonResource, usar el wrapper para encolver el result ['data' => results]

        return [
            'type' => 'articles',
            'id' => (string)$this->resource->getRouteKey(),
            'attributes' => [
                'title' => $this->resource->title,
                'slug' => $this->resource->slug,
                'content' => $this->resource->content
            ],
            'links' => [
                'self' => url('api/v1/articles/' . $this->resource->getRouteKey())
            ]
        ];
    }
}

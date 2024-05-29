<?php

namespace App\Http\Traits\Mobile;

trait PaginateTrait
{
    public function _paginate($collection): array
    {
        return [
            'meta' => [
                'current_page' => $collection->currentPage(),
                'from' => $collection->firstItem(),
                'last_page' => $collection->lastPage(),
                'path' => $collection->resolveCurrentPath(),
                'per_page' => $collection->perPage(),
                'to' => $collection->lastItem(),
                'total' => $collection->total(),
            ],
            'links' => [
                'first' => $collection->url(1),
                'last' => $collection->url($collection->lastPage()),
                'prev' => $collection->previousPageUrl(),
                'next' => $collection->nextPageUrl(),
            ],
        ];
    }

    public function getPaginate($collection): array
    {
        return [
            'total' => $collection->total(),
            'next' => $collection->nextPageUrl(),
            'prev' => $collection->previousPageUrl(),
        ];
    }
}

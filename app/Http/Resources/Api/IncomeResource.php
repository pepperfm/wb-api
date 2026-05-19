<?php

declare(strict_types=1);

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;
use Illuminate\Support\Arr;

final class IncomeResource extends JsonApiResource
{
    /**
     * @param Request $request
     *
     * @return array<string, mixed>
     */
    public function toAttributes(Request $request): array
    {
        return Arr::except($this->resource->toArray(), [
            'id',
            'created_at',
            'updated_at',
        ]);
    }
}

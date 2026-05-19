<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Api\StockStatisticsRequest;
use App\Http\Resources\Api\StockResource;
use App\Models\Stock;

final readonly class StocksController
{
    public function __invoke(StockStatisticsRequest $request): AnonymousResourceCollection
    {
        return StockResource::collection(
            Stock::query()
                ->whereDate('last_change_date', $request->validated('dateFrom'))
                ->oldest('last_change_date')
                ->oldest('id')
                ->paginate($request->limit())
        )->preserveQuery();
    }
}

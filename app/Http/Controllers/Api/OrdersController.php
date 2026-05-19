<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Api\StatisticsRequest;
use App\Http\Resources\Api\OrderResource;
use App\Models\Order;

final readonly class OrdersController
{
    public function __invoke(StatisticsRequest $request): AnonymousResourceCollection
    {
        return OrderResource::collection(
            Order::query()
                ->filters($request->validated('dateFrom'), $request->validated('dateTo'))
                ->paginate($request->limit())
        )->preserveQuery();
    }
}

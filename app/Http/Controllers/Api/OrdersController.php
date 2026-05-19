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
                ->whereDate('date', '>=', $request->validated('dateFrom'))
                ->whereDate('date', '<=', $request->validated('dateTo'))
                ->oldest('date')
                ->oldest('id')
                ->paginate($request->limit())
        )->preserveQuery();
    }
}

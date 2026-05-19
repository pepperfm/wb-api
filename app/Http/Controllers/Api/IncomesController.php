<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Api\StatisticsRequest;
use App\Http\Resources\Api\IncomeResource;
use App\Models\Income;

final readonly class IncomesController
{
    public function __invoke(StatisticsRequest $request): AnonymousResourceCollection
    {
        return IncomeResource::collection(
            Income::query()
                ->filters($request->validated('dateFrom'), $request->validated('dateTo'))
                ->paginate($request->limit())
        )->preserveQuery();
    }
}

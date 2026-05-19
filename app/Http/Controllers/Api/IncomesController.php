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
                ->whereDate('date', '>=', $request->validated('dateFrom'))
                ->whereDate('date', '<=', $request->validated('dateTo'))
                ->oldest('date')
                ->oldest('id')
                ->paginate($request->limit())
        )->preserveQuery();
    }
}

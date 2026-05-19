<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasFilters
{
    #[Scope]
    protected function filters(Builder $query, $dateFrom, $dateTo): Builder
    {
        return $query->whereDate('date', '>=', $dateFrom)
            ->whereDate('date', '<=', $dateTo)
            ->oldest('date')
            ->oldest('id');
    }
}

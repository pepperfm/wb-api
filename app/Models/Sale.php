<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Sale extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'date' => 'datetime:Y-m-d H:i:s',
            'last_change_date' => 'datetime:Y-m-d H:i:s',
            'total_price' => 'decimal:2',
            'discount_percent' => 'integer',
            'promo_code_discount' => 'integer',
            'income_id' => 'integer',
            'odid' => 'integer',
            'spp' => 'decimal:2',
            'for_pay' => 'decimal:2',
            'finished_price' => 'decimal:2',
            'price_with_disc' => 'decimal:2',
            'nm_id' => 'integer',
            'is_supply' => 'boolean',
            'is_realization' => 'boolean',
        ];
    }
}

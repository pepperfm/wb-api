<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Order extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'date' => 'datetime:Y-m-d H:i:s',
            'last_change_date' => 'datetime:Y-m-d H:i:s',
            'total_price' => 'decimal:2',
            'discount_percent' => 'integer',
            'income_id' => 'integer',
            'odid' => 'integer',
            'nm_id' => 'integer',
            'is_cancel' => 'boolean',
            'cancel_date' => 'datetime:Y-m-d H:i:s',
        ];
    }
}

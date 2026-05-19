<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Stock extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'last_change_date' => 'datetime:Y-m-d H:i:s',
            'nm_id' => 'integer',
            'quantity' => 'integer',
            'in_way_to_client' => 'integer',
            'in_way_from_client' => 'integer',
            'quantity_full' => 'integer',
            'price' => 'decimal:2',
            'discount' => 'integer',
            'is_supply' => 'boolean',
            'is_realization' => 'boolean',
        ];
    }
}

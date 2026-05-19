<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Income extends Model
{
    use HasFactory, HasUuids;

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
            'last_change_date' => 'datetime:Y-m-d H:i:s',
            'quantity' => 'integer',
            'total_price' => 'decimal:2',
            'nm_id' => 'integer',
        ];
    }
}

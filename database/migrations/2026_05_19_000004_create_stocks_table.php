<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->dateTime('last_change_date')->index();
            $table->string('warehouse_name')->nullable();
            $table->string('supplier_article')->nullable();
            $table->unsignedBigInteger('nm_id')->nullable()->index();
            $table->string('barcode')->nullable()->index();
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('in_way_to_client')->default(0);
            $table->unsignedInteger('in_way_from_client')->default(0);
            $table->unsignedInteger('quantity_full')->default(0);
            $table->string('category')->nullable();
            $table->string('subject')->nullable();
            $table->string('brand')->nullable();
            $table->string('tech_size')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedTinyInteger('discount')->default(0);
            $table->boolean('is_supply')->default(false);
            $table->boolean('is_realization')->default(false);
            $table->string('sc_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

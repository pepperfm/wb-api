<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->dateTime('date')->index();
            $table->dateTime('last_change_date')->nullable();
            $table->string('supplier_article')->nullable();
            $table->string('tech_size')->nullable();
            $table->string('barcode')->nullable()->index();
            $table->decimal('total_price', 12, 2)->default(0);
            $table->unsignedTinyInteger('discount_percent')->default(0);
            $table->boolean('is_supply')->default(false);
            $table->boolean('is_realization')->default(false);
            $table->unsignedTinyInteger('promo_code_discount')->default(0);
            $table->string('warehouse_name')->nullable();
            $table->string('country_name')->nullable();
            $table->string('oblast_okrug_name')->nullable();
            $table->string('region_name')->nullable();
            $table->unsignedBigInteger('income_id')->nullable()->index();
            $table->string('sale_id')->nullable()->index();
            $table->unsignedBigInteger('odid')->nullable()->index();
            $table->decimal('spp', 12, 2)->default(0);
            $table->decimal('for_pay', 12, 2)->default(0);
            $table->decimal('finished_price', 12, 2)->default(0);
            $table->decimal('price_with_disc', 12, 2)->default(0);
            $table->unsignedBigInteger('nm_id')->nullable()->index();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->string('g_number')->nullable()->index();
            $table->string('sticker')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

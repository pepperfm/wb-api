<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('income_id')->nullable()->index();
            $table->string('number')->nullable();
            $table->date('date')->index();
            $table->dateTime('last_change_date')->nullable();
            $table->string('supplier_article')->nullable();
            $table->string('tech_size')->nullable();
            $table->string('barcode')->nullable()->index();
            $table->unsignedInteger('quantity')->default(0);
            $table->decimal('total_price', 12, 2)->default(0);
            $table->unsignedBigInteger('nm_id')->nullable()->index();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};

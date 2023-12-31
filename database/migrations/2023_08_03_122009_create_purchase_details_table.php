<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchaseDetails', function (Blueprint $table) {
            $table->id('purchaseDetailId');
            $table->unsignedBigInteger('purchaseId');
            $table->foreign('purchaseId')->references('purchaseId')->on('purchases');
            $table->unsignedBigInteger('productId');
            $table->foreign('productId')->references('productId')->on('products');
            $table->unsignedBigInteger('unitId');
            $table->foreign('unitId')->references('unitId')->on('units');
            $table->decimal('prices', $precision = 10, $scale = 2);
            $table->decimal('qty', $precision = 10, $scale = 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchaseDetails');
    }
};

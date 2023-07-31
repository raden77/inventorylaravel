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
        Schema::create('products', function (Blueprint $table) {
            $table->id('productId');
            $table->string('productName',200);
            $table->string('dimensions',200);
            $table->decimal('qty', $precision = 10, $scale = 2);
            $table->unsignedBigInteger('productCategoriId');
            $table->foreign('productCategoriId')->references('productCategoriId')->on('productCategoris');
            $table->unsignedBigInteger('unitId');
            $table->foreign('unitId')->references('unitId')->on('units');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

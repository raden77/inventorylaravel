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
        Schema::create('unitConversions', function (Blueprint $table) {
            $table->id('unitConversionId');
            $table->unsignedBigInteger('fromUnit');
            $table->foreign('fromUnit')->references('unitId')->on('units');
            $table->unsignedBigInteger('toUnit');
            $table->foreign('toUnit')->references('unitId')->on('units');
            $table->decimal('ratio', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unitConversions');
    }
};

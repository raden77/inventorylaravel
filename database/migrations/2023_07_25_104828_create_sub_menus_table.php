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
        Schema::create('subMenus', function (Blueprint $table) {
            $table->id('subMenusId');
            $table->string('subMenuName',200);
            $table->string('subMenuIcon',200);
            $table->unsignedBigInteger('menuId');
            $table->foreign('menuId')->references('menuId')->on('menus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_menus');
    }
};

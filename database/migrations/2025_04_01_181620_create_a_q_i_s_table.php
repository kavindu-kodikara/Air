<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('aqi_data', function (Blueprint $table) {
        $table->id();
        $table->string('city');
        $table->decimal('latitude', 8, 6);
        $table->decimal('longitude', 9, 6);
        $table->integer('aqi_level');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aqi_data');
    }
};

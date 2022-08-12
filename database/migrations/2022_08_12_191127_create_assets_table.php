<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('name');
            $table->foreignId('category_id');
            $table->foreignId('location_id')->nullable()->default(null);
            $table->date('acquisition_date')->nullable()->default(null);
            $table->decimal('acquisition_price', 8, 2)->nullable()->default(null);
            $table->date('disposition_date')->nullable()->default(null);
            $table->decimal('disposition_price', 8, 2)->nullable()->default(null);
            $table->string('info_url')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
};

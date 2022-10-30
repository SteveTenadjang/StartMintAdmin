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
    public function up(): void
    {
        Schema::create('n_f_t_s', static function (Blueprint $table) {
            $table->id();
            $table->string('author_name');
            $table->string('media_link');
            $table->string('media_type');
            $table->string('title');
            $table->integer('max_quantity');
            $table->double('price');
            $table->string('description');
            $table->string('blockchain_type');
            $table->foreignId('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    { Schema::dropIfExists('n_f_t_s'); }
};

<?php

use Illuminate\Database\Migrations\Migration;
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
        Schema::table('n_f_t_s', static function ($table) {
            $table->foreign('created_by')->references('id')->on('users')
                ->nullOnDelete()->cascadeOnUpdate();
        });
        Schema::table('user_bundle', static function ($table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('bundle_id')->references('id')->on('bundles')
                ->nullOnDelete()->cascadeOnUpdate();
        });
    }
};

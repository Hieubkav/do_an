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
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['version_id']);
            $table->dropColumn('version_id');
            $table->unsignedBigInteger('color_version_size_id');

            $table->foreign('color_version_size_id')->references('id')->on('color_version_sizes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->unsignedBigInteger('version_id');
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('cascade');
        });
    }
};

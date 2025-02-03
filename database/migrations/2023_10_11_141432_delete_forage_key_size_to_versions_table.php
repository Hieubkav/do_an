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
        Schema::table('versions', function (Blueprint $table) {
            // Xoá khóa ngoại trước
            $table->dropForeign(['size_id']);
            // Xoá cột size_id
            $table->dropColumn('size_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('versions', function (Blueprint $table) {
            // Thêm lại cột size_id
            $table->unsignedBigInteger('size_id')->nullable();
            // Thêm lại khóa ngoại
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
        });
    }
};

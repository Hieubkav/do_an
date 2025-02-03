<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('banner_one_pic');
            $table->text('banner_one_big_text');
            $table->text('banner_one_small_text');
            $table->string('banner_two_pic');
            $table->text('banner_two_big_text');
            $table->text('banner_two_small_text');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

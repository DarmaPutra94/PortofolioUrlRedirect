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
        Schema::create('url_shorts', function (Blueprint $table) {
            $table->id();
            $table->longText('url');
            $table->string('url_hash', 64)->unique();
            $table->string('short_code', 10)->unique();
            $table->integer('access_count')->default(0);
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url_shorts');
    }
};

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
        Schema::table('url_shorts', function (Blueprint $table) {
            $table->dropColumn("url_hash");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('url_shorts', function (Blueprint $table) {
            $table->string('url_hash', 64)->nullable();
        });
    }
};

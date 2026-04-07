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
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->string('seo_title', 60)->nullable()->after('slug');
            $table->string('seo_description', 160)->nullable()->after('seo_title');
            $table->json('features')->nullable()->after('seo_description');
            $table->json('specifications')->nullable()->after('features');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'features', 'specifications']);
        });
    }
};

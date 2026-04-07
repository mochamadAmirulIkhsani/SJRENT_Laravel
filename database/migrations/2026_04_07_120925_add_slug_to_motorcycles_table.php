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
            $table->string('slug')->nullable()->after('name');
        });
        
        // Generate slugs for existing motorcycles
        $motorcycles = \App\Models\Motorcycle::withTrashed()->get();
        foreach ($motorcycles as $motorcycle) {
            $baseSlug = \Illuminate\Support\Str::slug($motorcycle->name);
            $slug = $baseSlug;
            $counter = 1;
            
            while (\App\Models\Motorcycle::withTrashed()->where('slug', $slug)->where('id', '!=', $motorcycle->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $motorcycle->slug = $slug;
            $motorcycle->saveQuietly();
        }
        
        // Make slug unique after populating
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};

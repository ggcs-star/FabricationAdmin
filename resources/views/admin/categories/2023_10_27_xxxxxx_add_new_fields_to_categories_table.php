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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('image')->nullable()->after('description');
            $table->string('meta_title')->nullable()->after('image');
            $table->text('meta_keywords')->nullable()->after('meta_title');
            $table->text('meta_description')->nullable()->after('meta_keywords');
            $table->integer('sort_order')->default(0)->after('meta_description');
            $table->boolean('is_featured')->default(false)->after('sort_order');
            $table->enum('visibility', ['public', 'private'])->default('public')->after('is_featured');
            $table->boolean('is_active')->default(true)->after('visibility');
        });
    }
}
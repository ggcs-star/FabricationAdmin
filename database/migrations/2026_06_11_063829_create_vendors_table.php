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
        Schema::create('vendors', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('business_name');
    
    // owner_name, email, phone HATA DIYE GAYE HAIN (Wo users table me rahenge)

    $table->string('gst_number')->nullable();
    $table->string('pan_number')->nullable();
    $table->string('aadhaar_number')->nullable();
    $table->text('address')->nullable();
    
    $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending');
    
    // Explicitly users table ko point karein
    $table->foreignId('approved_by')->nullable()->constrained('users'); 
    $table->timestamp('approved_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};

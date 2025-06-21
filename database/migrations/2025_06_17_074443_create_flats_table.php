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
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->string('flat_no');
            $table->string('tower')->nullable();
            $table->integer('floor')->nullable();
            $table->float('area_sq_ft')->nullable();
            $table->enum('status', ['occupied', 'vacant'])->default('occupied');
            $table->foreignId('resident_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};

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
        Schema::create('attachable', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('file_id')->nullable();
            $table->unsignedBigInteger('attachable_id')->nullable();
            $table->text('attachable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachable');
    }
};

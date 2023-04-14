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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('path')->nullable();
            $table->text('title')->nullable();
            $table->text('alt')->nullable();
            $table->text('uid')->nullable();
            $table->text('name')->nullable();
            $table->text('ext')->nullable();
            $table->text('inputFieldName')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};

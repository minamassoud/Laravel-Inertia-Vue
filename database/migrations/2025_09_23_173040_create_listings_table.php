<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 100);
            $table->text('desc');
            $table->string('tags')->nullable();
            $table->string('email')->nullable();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });
    }


};

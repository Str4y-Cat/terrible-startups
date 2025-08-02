<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId("user_id")->constrained()->onDelete("cascade")->onUpdate("cascade");

            $table->string("title");
            $table->string("rating")->nullable();
            $table->string("overview")->nullable();
            $table->string("type")->nullable();
            $table->string("problem_to_solve")->nullable();
            $table->string("inspiration")->nullable();
            $table->string("solution")->nullable();
            $table->string("features")->nullable();
            $table->string("target_audience")->nullable();
            $table->string("risks")->nullable();
            $table->string("challenges")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};

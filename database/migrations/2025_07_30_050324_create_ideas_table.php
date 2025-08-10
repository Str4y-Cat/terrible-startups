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
            $table->integer("rating")->nullable();
            $table->text("overview")->nullable();
            $table->string("type")->nullable();
            $table->text("problem_to_solve")->nullable();
            $table->text("inspiration")->nullable();
            $table->text("solution")->nullable();
            /* $table->text("features")->nullable(); */
            /* $table->text("target_audience")->nullable(); */
            /* $table->text("risks")->nullable(); */
            /* $table->text("challenges")->nullable(); */

            $table->jsonb("features")->nullable();
            $table->jsonb("target_audience")->nullable();
            $table->jsonb("risks")->nullable();
            $table->jsonb("challenges")->nullable();
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

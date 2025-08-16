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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            /* $table->foreignId("user_id")->constrained()->onDelete('cascade')->onUpdate("cascade"); */
            $table->foreignId("idea_id")->constrained()->onDelete('cascade')->onUpdate("cascade");

            $table->string("key")->nullable();
            $table->string("value");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};

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
        Schema::create('movings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(1);

            $table->foreignId('coming_id')->nullable()->constrained('comings')->cascadeOnDelete();

            $table->foreignId('from_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('to_user_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('from_box_id')->constrained('boxes')->cascadeOnDelete();
            $table->foreignId('to_box_id')->constrained('boxes')->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movings');
    }
};

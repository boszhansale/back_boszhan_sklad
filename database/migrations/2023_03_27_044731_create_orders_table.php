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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('payment_type')->default(1);
            $table->tinyInteger('payment_status')->default(2);


            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('counteragent_id')->nullable()->constrained('counteragents')->cascadeOnDelete();
            $table->foreignId('store_id')->nullable()->constrained('stores')->cascadeOnDelete();
            $table->decimal('total_price',20,2);

            $table->decimal('discount_cashback',20,2);
            $table->string('discount_phone')->nullable();

            $table->boolean('online_sale')->default(0);

            $table->timestamp('removed_at')->nullable();
            $table->date('delivery_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

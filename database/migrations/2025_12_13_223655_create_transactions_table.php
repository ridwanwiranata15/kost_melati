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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();

            $table->string('payment_method', 50)->default('transfer');
            $table->string('payment_receipt')->nullable();

            $table->unsignedBigInteger('amount')->default(0);
            $table->unsignedBigInteger('nominal')->default(0);

            $table->date('due_date')->nullable()->index();
            $table->date('date_pay')->nullable()->index();

            $table->enum('status', ['pending', 'confirmed', 'rejected'])
                ->default('pending')
                ->index();

            $table->timestamp('h7_reminded_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

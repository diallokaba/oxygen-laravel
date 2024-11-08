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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users');
            $table->string('receiver_phone');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['TRANSFER', 'PAYMENT', 'DEPOT', 'RETRAIT']);
            $table->enum('status', ['SUCCES', 'ECHOUER', 'ANNULER']);
            $table->timestamp('scheduled_at')->nullable(); // Pour les transferts planifiés
            $table->enum('recurrence', ['NONE', 'DAILY', 'WEEKLY', 'MONTHLY'])->default('NONE');
            $table->timestamp('cancelled_at')->nullable();
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

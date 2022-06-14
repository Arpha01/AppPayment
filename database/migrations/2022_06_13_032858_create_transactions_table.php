<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('event_id')->constrained('events');
            $table->integer('amount');
            $table->string('total_price', 8);
            $table->enum('status', ['pending', 'paid', 'cancelled']);
            $table->enum('payment_method', ['bri', 'bca', 'bni', 'indomaret', 'alfamart', 'gopay']);
            $table->dateTime('expired_at')->nullable();
            $table->text('payment_code')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->json('ticket_schedules');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};

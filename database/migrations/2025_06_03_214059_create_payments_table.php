<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_payments_table.php
public function up() :void
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('payment_code')->unique(); // mã giao dịch
        $table->integer('amount'); // số tiền
        $table->string('method'); // 'vnpay', 'momo', etc.
        $table->enum('type', ['deposit', 'withdraw', 'order'])->default('deposit'); // loại giao dịch nap, rút, thanh toán đơn hàng
        $table->string('status')->default('pending'); // pending, success, failed
        $table->text('note')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

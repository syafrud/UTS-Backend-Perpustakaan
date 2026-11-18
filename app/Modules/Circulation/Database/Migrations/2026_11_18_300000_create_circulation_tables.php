<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            // ID dari modul lain disimpan sebagai referensi saja (tanpa FK & tanpa relasi Eloquent)
            // agar batas modul tetap tegas; akses datanya lewat Contract.
            $table->unsignedBigInteger('member_id')->index();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // petugas
            $table->date('loaned_at');
            $table->date('due_at');
            $table->date('returned_at')->nullable();
            $table->unsignedInteger('fine_per_day'); // snapshot aturan saat pinjam
            $table->timestamps();
        });

        Schema::create('loan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('book_id')->index();
            $table->timestamps();
        });

        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedInteger('days_late');
            $table->unsignedInteger('amount');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fines');
        Schema::dropIfExists('loan_items');
        Schema::dropIfExists('loans');
    }
};

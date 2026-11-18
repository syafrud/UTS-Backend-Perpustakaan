<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedTinyInteger('max_loans');      // maks. buku dipinjam bersamaan
            $table->unsignedTinyInteger('loan_days');      // lama pinjam (hari)
            $table->unsignedInteger('fine_per_day');       // denda per hari telat (Rp)
            $table->timestamps();
        });

        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_type_id')->constrained()->restrictOnDelete();
            $table->string('member_code', 20)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
        Schema::dropIfExists('membership_types');
    }
};

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->required()->nullable(false)->comment('username cannot be empty');
            $table->string('password')->required()->nullable(false)->comment('password cannot be empty');
            $table->string('email')->required()->unique()->nullable(false);
            $table->string('email_verified_at')->required()->nullable(true);
            $table->string('full_name')->required()->nullable(false)->comment('full name cannot be empty');
            $table->string('address')->required()->nullable(false)->comment('address cannot be empty');
            $table->string('phone')->required()->nullable(false)->comment('phone cannot be empty');
            $table->boolean('role')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

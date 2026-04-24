<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->string('url', 500);
            $table->string('device_type', 20)->default('Desktop'); // Mobile, Desktop, Tablet
            $table->string('browser', 100)->nullable();
            $table->string('os', 100)->nullable();
            $table->timestamps();

            // Indexes for fast analytics queries
            $table->index('created_at');
            $table->index('ip_address');
            $table->index('device_type');
            $table->index(['ip_address', 'url', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};

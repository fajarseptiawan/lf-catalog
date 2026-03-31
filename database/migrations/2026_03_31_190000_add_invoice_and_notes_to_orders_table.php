<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('invoice_code')->nullable()->after('id');
            $table->text('notes')->nullable()->after('address');
        });

        // Make product_id nullable using raw SQL (avoids doctrine/dbal)
        DB::statement('ALTER TABLE orders MODIFY product_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['invoice_code', 'notes']);
        });

        DB::statement('ALTER TABLE orders MODIFY product_id BIGINT UNSIGNED NOT NULL');
    }
};

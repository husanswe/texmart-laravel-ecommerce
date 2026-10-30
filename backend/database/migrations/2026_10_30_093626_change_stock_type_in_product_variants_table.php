<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->unsignedInteger('stock')->default(0)->change();
        });
    }


    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('stock', 255)->default('0')->change();
        });
    }
};

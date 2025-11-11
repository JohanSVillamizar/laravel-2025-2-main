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
        Schema::table('computers', function (Blueprint $table) {
            if (!Schema::hasColumn('computers', 'computer_brand')) {
                $table->string('computer_brand')->nullable();
            }
            if (!Schema::hasColumn('computers', 'computer_model')) {
                $table->string('computer_model')->nullable();
            }
            if (!Schema::hasColumn('computers', 'computer_price')) {
                $table->decimal('computer_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('computers', 'computer_ram_size')) {
                $table->integer('computer_ram_size')->nullable();
            }
            if (!Schema::hasColumn('computers', 'computer_is_laptop')) {
                $table->boolean('computer_is_laptop')->default(false);
            }
            if (!Schema::hasColumn('computers', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable();
            }
            if (!Schema::hasColumn('computers', 'computers_barcode')) {
                $table->string('computers_barcode')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('computers', function (Blueprint $table) {
            $table->dropColumn([
                'computer_brand',
                'computer_model',
                'computer_price',
                'computer_ram_size',
                'computer_is_laptop',
                'category_id',
                'computers_barcode',
            ]);
        });
    }
};
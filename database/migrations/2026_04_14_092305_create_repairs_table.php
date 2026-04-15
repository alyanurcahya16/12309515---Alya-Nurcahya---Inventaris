<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_repairs_table.php
public function up()
{
    Schema::create('repairs', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->string('customer_email');
        $table->string('customer_phone');
        $table->string('item_type');
        $table->text('issue_description');
        $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};

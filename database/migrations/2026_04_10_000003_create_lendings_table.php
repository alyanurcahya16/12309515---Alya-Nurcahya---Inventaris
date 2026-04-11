<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('lendings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('item_id')->constrained()->onDelete('cascade');
        $table->integer('total');
        $table->string('user');
        $table->text('note')->nullable();
        $table->dateTime('datetime');
        $table->boolean('returned')->default(false);
        $table->string('edited_by')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('lendings');
    }
};

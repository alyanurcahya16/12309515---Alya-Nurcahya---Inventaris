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
        Schema::table('lendings', function (Blueprint $table) {

            // CEK dulu apakah kolom ada (biar aman)
            if (Schema::hasColumn('lendings', 'item_id')) {

                // hapus foreign key (auto detect)
                try {
                    $table->dropForeign(['item_id']);
                } catch (\Exception $e) {
                    // kalau gagal, skip (biar tidak error)
                }

                // hapus kolom
                $table->dropColumn('item_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lendings', function (Blueprint $table) {

            // balikin lagi kolom (kalau rollback)
            $table->unsignedBigInteger('item_id')->nullable();

            // tambahkan kembali foreign key
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }
};

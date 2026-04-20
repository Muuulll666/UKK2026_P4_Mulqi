<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tabel kategori
        if (!Schema::hasTable('kategori')) {
            Schema::create('kategori', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('deskripsi')->nullable();
                $table->timestamps();
            });
        }
        // Kolom kategori_id di buku
        if (!Schema::hasColumn('buku', 'kategori_id')) {
            Schema::table('buku', function (Blueprint $table) {
                $table->unsignedBigInteger('kategori_id')->nullable()->after('rak_id');
                $table->foreign('kategori_id')->references('id')->on('kategori')->nullOnDelete();
            });
        }
        // Kolom lama_pinjam di transaksi
        if (!Schema::hasColumn('transaksi', 'lama_pinjam')) {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->integer('lama_pinjam')->default(7)->after('denda');
            });
        }
    }
    public function down(): void {
        Schema::table('transaksi', function (Blueprint $table) {
            if (Schema::hasColumn('transaksi', 'lama_pinjam')) $table->dropColumn('lama_pinjam');
        });
        Schema::table('buku', function (Blueprint $table) {
            if (Schema::hasColumn('buku', 'kategori_id')) {
                try { $table->dropForeign(['kategori_id']); } catch (\Exception $e) {}
                $table->dropColumn('kategori_id');
            }
        });
        Schema::dropIfExists('kategori');
    }
};

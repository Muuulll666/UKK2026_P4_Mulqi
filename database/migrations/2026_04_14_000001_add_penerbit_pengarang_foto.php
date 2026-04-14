<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel penerbit (skip kalau sudah ada)
        if (!Schema::hasTable('penerbit')) {
            Schema::create('penerbit', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('kota')->nullable();
                $table->string('telepon')->nullable();
                $table->timestamps();
            });
        }

        // Tabel pengarang (skip kalau sudah ada)
        if (!Schema::hasTable('pengarang')) {
            Schema::create('pengarang', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->text('biografi')->nullable();
                $table->timestamps();
            });
        }

        // Update tabel buku: tambah foto & pengarang_id (penerbit_id sudah ada)
        Schema::table('buku', function (Blueprint $table) {
            if (!Schema::hasColumn('buku', 'foto')) {
                $table->string('foto')->nullable()->after('stok');
            }
            if (!Schema::hasColumn('buku', 'pengarang_id')) {
                $table->foreignId('pengarang_id')->nullable()->constrained()->nullOnDelete()->after('foto');
            }
            // Foreign key untuk penerbit_id yang sudah ada
            $table->foreignId('penerbit_id')->nullable()->constrained('penerbit')->nullOnDelete();
        });

        // Update tabel users: tambah foto profil
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'foto')) {
                $table->dropColumn('foto');
            }
        });
        Schema::table('buku', function (Blueprint $table) {
            try {
                $table->dropForeign(['pengarang_id']);
            } catch (\Exception $e) {}
            try {
                $table->dropForeign(['penerbit_id']);
            } catch (\Exception $e) {}
            if (Schema::hasColumn('buku', 'foto')) {
                $table->dropColumn('foto');
            }
            if (Schema::hasColumn('buku', 'pengarang_id')) {
                $table->dropColumn('pengarang_id');
            }
        });
        Schema::dropIfExists('pengarang');
        Schema::dropIfExists('penerbit');
    }
};
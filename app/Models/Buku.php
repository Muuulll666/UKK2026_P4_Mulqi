<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    public $timestamps = false;

    protected $table = 'buku';

    protected $fillable = [
        'judul', 'penulis', 'penerbit', 'tahun', 'stok', 'rak_id', 'kategori_id',
        'pengarang', 'penerbit_id', 'pengarang_id', 'foto'
    ];

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }

    public function penerbitRelasi()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id');
    }

    public function pengarangRelasi()
    {
        return $this->belongsTo(Pengarang::class, 'pengarang_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'buku_id');
    }
}
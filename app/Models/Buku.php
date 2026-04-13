<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    public $timestamps = false;

    protected $table = 'buku';

    protected $fillable = [
        'judul', 'penulis', 'penerbit', 'tahun', 'stok', 'rak_id', 'pengarang', 'penerbit_id'
    ];

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'buku_id');
    }
}
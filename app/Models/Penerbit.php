<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    public $timestamps = false;

    protected $table = 'penerbit';

    protected $fillable = ['nama', 'kota', 'telepon'];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'penerbit_id');
    }
}

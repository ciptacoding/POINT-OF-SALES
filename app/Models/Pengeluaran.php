<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran';
    protected $primaryKey = 'kode_t';
    public $timestamps = false;
    protected $fillable = [
        'kode_t',
        'tanggal',
        'transaksi',
        'total',
        'keterangan'
    ];
}

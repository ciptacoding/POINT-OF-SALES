<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
	use HasFactory;
	protected $table = 'barang';
	protected $primaryKey = 'kode_barang';
	protected $keyType = 'string';
	public $timestamps = false;
	protected $fillable = [
		'kode_barang',
		'nama_barang',
		'harga',
		'kode_stok',
		'hpp',
	];
}

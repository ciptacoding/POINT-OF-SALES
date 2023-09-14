<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
	use HasFactory;
	protected $table = 'stok';
	protected $primaryKey = 'kode_stok';
	protected $keyType = 'string';
	public $timestamps = false;
	protected $fillable = [
		'kode_stok',
		'jumlah_stok',
	];
}

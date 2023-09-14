<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;
    protected $table = 'distributor';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'alamat',
        'no_tlp'
    ];
}

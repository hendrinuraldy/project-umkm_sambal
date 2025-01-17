<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = "promos";
    protected $primaryKey = 'id';

    protected $fillable = [
        'judul',
        'deskripsi',
        'harga',
        'image'
    ];
}
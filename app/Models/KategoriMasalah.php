<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMasalah extends Model
{
    use HasFactory;
    protected $table = 'kategori_permasalahan';
    protected $primaryKey = 'id_kategori';
}
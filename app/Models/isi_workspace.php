<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class isi_workspace extends Model
{
    use HasFactory;
    protected $table = 'isi_workspace';
    public $timestamps = false;
    protected $primaryKey = 'id_workspace';

    public function workspace(){
        return $this->belongsTo(Workspace::class,'id_workspace');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use IsiWorkspace;

class Workspace extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'workspace';
    protected $primaryKey = 'id_workspace';

    public function user(){
        return $this->belongsTo(User::class,'id_pamong');
    }

    public function isi(){
        return $this->belongsTo(isi_workspace::class,'id_workspace');
    }
}
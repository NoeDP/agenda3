<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use SoftDeletes;
    protected $table = 'horarios';
    protected $guarded = [];
    protected $dates = ['deleted_at'];


    public function evento()
    {
        return $this->belongsTo(Evento::class, 'eventos_id');
    }
}

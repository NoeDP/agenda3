<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;




class Foro extends Model
{
    use SoftDeletes , Searchable;
    protected $table = 'foros';
    protected $fillable = ['nombre', 'sede',];

    protected $dates = ['deleted_at'];

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'foros_id');
    }
    
}

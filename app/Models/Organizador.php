<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Organizador extends Model
{
    use SoftDeletes,Searchable;
    protected $table = 'organizadors';
    protected $fillable = ['nombre', 'telefono'];
    protected $dates = ['deleted_at'];

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'organizadors_id');
    }
    
    public function toSearchableArray()
    {
        return [
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
        ];
    }
}

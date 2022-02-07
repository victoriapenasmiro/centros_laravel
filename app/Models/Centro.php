<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Centro extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cod_asd',
        'fec_comienzo_actividad',
        'opcion_radio',
        'guarderia',
        'categoria',
    ];


    /**
     * Un centro tiene muchos ambitos
     */
    public function ambitos() {
        return $this->belongsToMany(Ambito::class, 'centros_ambitos', 'centro_id', 'ambito_id')->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centro_Ambito extends Model
{
    use HasFactory;

    protected $table = 'centros_ambitos';

    protected $fillable = [
        'centro_id',
        'ambito_id',
    ];
}

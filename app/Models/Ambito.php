<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambito extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    /**
     * Un ambito tiene muchos centros
     */
    public function centros() {
        return $this->belongsToMany(Centro::class)->withTimestamps();
    }
}

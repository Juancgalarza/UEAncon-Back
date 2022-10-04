<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/detalle_calificacionesModel.php';

use Illuminate\Database\Eloquent\Model;

class Quimestre extends Model
{
    protected $table = "quimestre";
    protected $fillable = ['quimestre','estado'];
    public $timestamps = false;

    public function detalle_calificaciones()
    {
        return $this->hasMany(Detalle_Calificaciones::class);
    }

} 
<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/detalle_asignacionesModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Quimestre extends Model
{
    protected $table = "quimestre";
    protected $fillable = ['quimestre','estado'];
    public $timestamps = false;

    public function detalle_asignaciones()
    {
        return $this->hasMany(Detalle_Asignaciones::class);
    }


}
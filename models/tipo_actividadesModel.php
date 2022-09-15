<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/detalle_asignacionesModel.php';
 

use Illuminate\Database\Eloquent\Model;

class Tipo_Actividades extends Model
{

    protected $table = "tipo_actividades";
    public $timestamps = false;

    public function detalle_asignaciones()
    {
        return $this->hasMany(Detalle_Asignaciones::class);
    }
    
 
}


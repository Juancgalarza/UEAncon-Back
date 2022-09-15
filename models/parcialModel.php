<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/detalle_asignacionesModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Parcial extends Model
{
    protected $table = "parcial";
    protected $fillable = ['nombre_curso','estado'];
    public $timestamps = false;

    
    public function detalle_asignaciones()
    {
        return $this->hasMany(Detalle_Asignaciones::class);
    }

} 
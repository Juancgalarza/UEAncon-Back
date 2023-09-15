<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/calificacionesModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Detalle_Calificaciones extends Model
{
    protected $table = "detalle_calificaciones";
    protected $fillable = ['calificaciones_id','nota1','nota2','nota3','nota4','nota5','nota6','total','promedio'];
    public $timestamps = false;

    public function calificaciones()
    {
        return $this->belongsTo(Calificaciones::class);
    }

} 
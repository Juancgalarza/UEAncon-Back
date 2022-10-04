<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/calificacionesModel.php';
require_once 'models/parcialModel.php';
require_once 'models/quimestreModel.php';
require_once 'models/estudianteModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Detalle_Calificaciones extends Model
{
    protected $table = "detalle_calificaciones";
    protected $fillable = ['calificaciones_id','parcial_id','quimestre_id','estudiante_id','nota1','nota2','nota3','nota4','nota5','nota6','total','promedio','examen'];
    public $timestamps = false;

    public function calificaciones()
    {
        return $this->belongsTo(Calificaciones::class);
    }

    public function parcial()
    {
        return $this->belongsTo(Parcial::class);
    }

    public function quimestre()
    {
        return $this->belongsTo(Quimestre::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
} 
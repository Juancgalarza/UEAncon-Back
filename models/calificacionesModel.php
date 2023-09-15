<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/docenteModel.php';
require_once 'models/materiaModel.php';
require_once 'models/cursoModel.php';
require_once 'models/paraleloModel.php';
require_once 'models/detalle_calificacionesModel.php';
require_once 'models/parcialModel.php';
require_once 'models/quimestreModel.php';
require_once 'models/estudianteModel.php';

use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    protected $table = "calificaciones";
    protected $fillable = ['estudiante_id','docente_id','materia_id','curso_id','paralelo_id','parcial_id','quimestre_id','promedio_parcial','estado'];
    public $timestamps = false;

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }

    public function detalle_calificaciones()
    {
        return $this->hasMany(Detalle_Calificaciones::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function parcial()
    {
        return $this->belongsTo(Parcial::class);
    }

    public function quimestre()
    {
        return $this->belongsTo(Quimestre::class);
    }

} 
<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/docenteModel.php';
require_once 'models/materiaModel.php';
require_once 'models/cursoModel.php';
require_once 'models/paraleloModel.php';
require_once 'models/detalle_calificacionesModel.php';

use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    protected $table = "calificaciones";
    protected $fillable = ['docente_id','materia_id','curso_id','paralelo_id','promedio_total','estado'];
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


} 
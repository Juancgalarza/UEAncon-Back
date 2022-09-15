<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/docenteModel.php';
require_once 'models/materiaModel.php';
require_once 'models/estudianteModel.php';
require_once 'models/cursoModel.php';
require_once 'models/paraleloModel.php';
require_once 'models/detalle_asignacionesModel.php';

use Illuminate\Database\Eloquent\Model;

class Asignaciones extends Model
{
    protected $table = "asignaciones";
    protected $fillable = ['docente_id','materia_id','estudiante','curso_id','paralelo_id','total','estado'];
    public $timestamps = false;

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }

    public function detalle_asignaciones()
    {
        return $this->hasMany(Detalle_Asignaciones::class);
    }


} 
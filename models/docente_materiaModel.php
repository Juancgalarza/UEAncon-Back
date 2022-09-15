<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/docenteModel.php';
require_once 'models/materiaModel.php';
require_once 'models/cursoModel.php';
require_once 'models/paraleloModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Docente_Materia extends Model
{
    protected $table = "docente_materia";
    protected $fillable = ['docente_id','materia_id','curso_id','paralelo_id','estado'];
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

} 
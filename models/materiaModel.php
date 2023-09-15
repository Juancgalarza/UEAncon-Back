<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/curso_materiaModel.php';
require_once 'models/docente_materiaModel.php';
require_once 'models/calificacionesModel.php';
require_once 'models/examenModel.php';

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = "materia";
    protected $fillable = ['nombre_materia','estado'];
    public $timestamps = false;

    public function curso_materia()
    {
        return $this->hasMany(Curso_Materia::class);
    }

    public function docente_materia()
    {
        return $this->hasMany(Docente_Materia::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificaciones::class);
    }

    public function examen()
    {
        return $this->hasMany(Examen::class);
    }


} 
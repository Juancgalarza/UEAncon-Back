<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/curso_materiaModel.php';
require_once 'models/docente_materiaModel.php';
require_once 'models/asignacionesModel.php';


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
    public function asignaciones()
    {
        return $this->hasMany(Asignaciones::class);
    }


} 
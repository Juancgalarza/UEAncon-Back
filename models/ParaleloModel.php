<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/docente_materiaModel.php';
require_once 'models/calificacionesModel.php';

use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    protected $table = "paralelo";
    protected $fillable = ['tipo','capacidad','total_estudiantes','estado'];
    public $timestamps = false;

    public function docente_materia()
    {
        return $this->hasMany(Docente_Materia::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificaciones::class);
    }

} 
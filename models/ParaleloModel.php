<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/docente_materiaModel.php';
require_once 'models/asignacionesModel.php';


 
use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    protected $table = "paralelo";
    protected $fillable = ['tipo','estado'];
    public $timestamps = false;

    public function docente_materia()
    {
        return $this->hasMany(Docente_Materia::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignaciones::class);
    }

} 
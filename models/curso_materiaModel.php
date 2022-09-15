<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/cursoModel.php';
require_once 'models/materiaModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Curso_Materia extends Model
{
    protected $table = "curso_materia";
    protected $fillable = ['curso_id','materia_id','estado'];
    public $timestamps = false;

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

} 
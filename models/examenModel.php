<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/quimestreModel.php';
require_once 'models/estudianteModel.php';
require_once 'models/materiaModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    protected $table = "examen";
    protected $fillable = ['quimestre_id','estudiante_id','materia_id','nota','estado'];
    public $timestamps = false;

    public function quimestre()
    {
        return $this->belongsTo(Quimestre::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

} 
<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/personaModel.php';
require_once 'models/cursoModel.php';
require_once 'models/paraleloModel.php';
require_once 'models/calificacionesModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = "estudiante";
    protected $fillable = ['persona_id','curso_id','paralelo_id','estado'];
    public $timestamps = false;
    
    //Muchos a uno --- uno a muchos(Inverso)
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }
    public function calificaciones()
    {
        return $this->hasMany(Calificaciones::class);
    }




    
} 
 
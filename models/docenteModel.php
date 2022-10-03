<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/personaModel.php';
require_once 'models/docente_materiaModel.php';
require_once 'models/calificacionesModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{

    protected $table = "docente";
    protected $fillable = ['persona_id','estado'];
    public $timestamps = false;
    
    //Muchos a uno --- uno a muchos(Inverso)
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function docente_materia()
    {
        return $this->hasMany(Docente_Materia::class);
    }
    public function calificaciones()
    {
        return $this->hasMany(Calificaciones::class);
    }




    
} 
 
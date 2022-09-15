<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/usuarioModel.php';
require_once 'models/estudianteModel.php';
require_once 'models/docenteModel.php';
require_once 'models/sexoModel.php';

use Illuminate\Database\Eloquent\Model;


class Persona extends Model
{

    protected $table = "persona";
    protected $fillable = ['sexo_id','cedula','nombres','apellidos','celular','direccion','estado'];
    public $timestamps = false;
    
    //uno a muchos
    public function usuario()
    {
        return $this->hasMany(Usuario::class);
    }
    public function estudiante()
    {
        return $this->hasMany(Estudiante::class);
    }
 
    public function docente()
    {
        return $this->hasMany(Docente::class);
    }

    public function sexo()
    {
        return $this->belongsTo(Sexo::class);
    }
 

}
  
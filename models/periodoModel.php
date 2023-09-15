<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/docente_materiaModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = "periodo";
    protected $fillable = ['periodo','estado_periodo_id','estado'];
    public $timestamps = false;

    public function docente_materia()
    {
        return $this->hasMany(Docente_Materia::class);
    }

} 
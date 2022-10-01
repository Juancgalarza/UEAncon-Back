<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/cursoModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    protected $table = "jornada";
    protected $fillable = ['jornada','estado'];
    public $timestamps = false;

    public function curso()
    {
        return $this->hasMany(Curso::class);
    }

} 
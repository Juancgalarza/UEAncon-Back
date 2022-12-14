<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/personaModel.php';

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $table = "sexo";
    protected $fillable = ['sexo','estado'];
    public $timestamps = false;

    public function persona()
    {
        return $this->hasMany(Persona::class);
    }
    
}
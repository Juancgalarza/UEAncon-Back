<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
 
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = "periodo";
    protected $fillable = ['periodo','estado'];
    public $timestamps = false;

} 
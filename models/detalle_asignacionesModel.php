<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/asignacionesModel.php';
require_once 'models/parcialModel.php';
require_once 'models/quimestreModel.php';
require_once 'models/tipo_actividadesModel.php';
 
use Illuminate\Database\Eloquent\Model;

class Detalle_Asignaciones extends Model
{
    protected $table = "detalle_asignaciones";
    protected $fillable = ['asignaciones_id','parcial_id','quimestre_id','tipo_actividades_id','calificacion'];
    public $timestamps = false;

    public function asignaciones()
    {
        return $this->belongsTo(Asignaciones::class);
    }
    public function parcial()
    {
        return $this->belongsTo(Parcial::class);
    }
    public function quimestre()
    {
        return $this->belongsTo(Quimestre::class);
    }
    public function tipo_actividades()
    {
        return $this->belongsTo(Tipo_Actividades::class);
    }
  

} 
<?php
require_once 'app/error.php';

class Detalle_AsignacionesAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/detalle_asignaciones/reportexParcialQuimestre' && $params) {
                    Route::get('/detalle_asignaciones/reportexParcialQuimestre/:parcial_id/:quimestre_id/:estudiante_id', 'detalle_asignacionesController@reportexParcialQuimestre',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

        }
    }
}
<?php
require_once 'app/error.php';

class Detalle_CalificacionesAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/detalle_calificaciones/reportexParcial' && $params) {
                    Route::get('/detalle_calificaciones/reportexParcial/:parcial_id/:estudiante_id', 'detalle_calificacionesController@reportexParcial',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

        }
    }
}
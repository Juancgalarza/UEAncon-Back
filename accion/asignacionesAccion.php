<?php
require_once 'app/error.php';

class AsignacionesAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/asignaciones/listarxId' && $params) {
                    Route::get('/asignaciones/listarxId/:id', 'asignacionesController@listarxId',$params);
                }else
                if ($ruta == '/asignaciones/listar') {
                    Route::get('/asignaciones/listar', 'asignacionesController@listar');
                }else
                if ($ruta == '/asignaciones/reportexParcial' && $params) {
                    Route::get('/asignaciones/reportexParcial/:estudiante_id', 'asignacionesController@reportexParcial',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/asignaciones/guardarAsignacion') {
                    Route::post('/asignaciones/guardarAsignacion', 'asignacionesController@guardar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }    
            break;
        }
    }
}
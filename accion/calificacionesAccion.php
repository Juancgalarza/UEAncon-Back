<?php
require_once 'app/error.php';

class CalificacionesAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/calificaciones/listarxId' && $params) {
                    Route::get('/calificaciones/listarxId/:id', 'calificacionesController@listarxId',$params);
                }else
                if ($ruta == '/calificaciones/listar') {
                    Route::get('/calificaciones/listar', 'calificacionesController@listar');
                }else
                if ($ruta == '/calificaciones/reportexParcial' && $params) {
                    Route::get('/calificaciones/reportexParcial/:estudiante_id', 'calificacionesController@reportexParcial',$params);
                }else
                if ($ruta == '/calificaciones/desgloseCalificacion' && $params) {
                    Route::get('/calificaciones/desgloseCalificacion/:docente_id', 'calificacionesController@desgloseCalificacion',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/calificaciones/guardarCalificacion') {
                    Route::post('/calificaciones/guardarCalificacion', 'calificacionesController@guardar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }    
            break;
        }
    }
}
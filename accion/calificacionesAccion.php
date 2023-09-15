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
                    Route::get('/calificaciones/reportexParcial/:parcial_id/:quimestre_id/:estudiante_id', 'calificacionesController@reportexParcial',$params);
                }else
                if ($ruta == '/calificaciones/desgloseCalificacion' && $params) {
                    Route::get('/calificaciones/desgloseCalificacion/:docente_id', 'calificacionesController@desgloseCalificacion',$params);
                }else
                if ($ruta == '/calificaciones/reporteQuimestral' && $params) {
                    Route::get('/calificaciones/reporteQuimestral/:quimestre_id/:estudiante_id', 'calificacionesController@reporteQuimestral',$params);
                }else
                if ($ruta == '/calificaciones/reporteAnual' && $params) {
                    Route::get('/calificaciones/reporteAnual/:estudiante_id', 'calificacionesController@reporteAnual',$params);
                }else
                if ($ruta == '/calificaciones/reportexParcialDocente' && $params) {
                    Route::get('/calificaciones/reportexParcialDocente/:parcial_id/:quimestre_id/:materia_id/:curso_id/:paralelo_id', 'calificacionesController@reportexParcialDocente',$params);
                }else
                if ($ruta == '/calificaciones/reporteQuimestralDocente' && $params) {
                    Route::get('/calificaciones/reporteQuimestralDocente/:quimestre_id/:materia_id/:curso_id/:paralelo_id', 'calificacionesController@reporteQuimestralDocente',$params);
                }else
                if ($ruta == '/calificaciones/reporteAnualDocente' && $params) {
                    Route::get('/calificaciones/reporteAnualDocente/:materia_id/:curso_id/:paralelo_id', 'calificacionesController@reporteAnualDocente',$params);
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
<?php

require_once 'app/error.php';

class Curso_MateriaAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/curso_materia/listar' && $params) {
                    Route::get('/curso_materia/listar/:id', 'curso_materiaController@listarId',$params);
                }else
                if ($ruta == '/curso_materia/listar') {
                    Route::get('/curso_materia/listar', 'curso_materiaController@listar');
                }else
                if ($ruta == '/curso_materia/datatableAsignaciones') {
                    Route::get('/curso_materia/datatableAsignaciones', 'curso_materiaController@dataTableAsignaciones');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
                break;

            case 'post':
                if ($ruta == '/curso_materia/save') {
                    Route::post('/curso_materia/save', 'curso_materiaController@guardar');
                }else 
                if($ruta == '/curso_materia/eliminar'){
                    Route::post('/curso_materia/eliminar', 'curso_materiaController@eliminar');
                }else 
                if($ruta == '/curso_materia/editar'){
                    Route::post('/curso_materia/editar', 'curso_materiaController@editar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                break;
            case 'delete':
                if ($params) {
                    if ($ruta == '/curso_materia/eliminarCursoMateria' && $params) {
                        Route::delete('/curso_materia/eliminarCursoMateria/:id', 'curso_materiaController@eliminarCursoMateria', $params);
                    } 
                } else {
                    ErrorClass::e(400, 'No ha enviado parámetros por la url');
                }
            break;
    
 
        }
    }
}
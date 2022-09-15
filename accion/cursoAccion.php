<?php

require_once 'app/error.php';

class CursoAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/curso/listar' && $params) {
                    Route::get('/curso/listar/:id', 'cursoController@listarId',$params);
                }else
                if ($ruta == '/curso/listar') {
                    Route::get('/curso/listar', 'cursoController@listar');
                }else
                if ($ruta == '/curso/datatable') {
                    Route::get('/curso/datatable', 'cursoController@dataTable');
                }else
                if ($ruta == '/curso/datatableAsignar') {
                    Route::get('/curso/datatableAsignar', 'cursoController@datatableAsignar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
                break;

            case 'post':
                if ($ruta == '/curso/save') {
                    Route::post('/curso/save', 'cursoController@guardar');
                }else 
                if($ruta == '/curso/eliminar'){
                    Route::post('/curso/eliminar', 'cursoController@eliminar');
                }else 
                if($ruta == '/curso/editar'){
                    Route::post('/curso/editar', 'cursoController@editar');
                }
                break;
 
        }
    }
}
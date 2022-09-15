<?php

require_once 'app/error.php';

class ParaleloAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/paralelo/listar' && $params) {
                    Route::get('/paralelo/listar/:id', 'paraleloController@listarId',$params);
                }else
                if ($ruta == '/paralelo/listar') {
                    Route::get('/paralelo/listar', 'paraleloController@listar');
                }else
                if ($ruta == '/paralelo/datatable') {
                    Route::get('/paralelo/datatable', 'paraleloController@dataTable');
                }else
                if ($ruta == '/paralelo/datatableAsignar') {
                    Route::get('/paralelo/datatableAsignar', 'paraleloController@datatableAsignar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
                break;

            case 'post':
                if ($ruta == '/paralelo/save') {
                    Route::post('/paralelo/save', 'paraleloController@guardar');
                }else 
                if($ruta == '/paralelo/eliminar'){
                    Route::post('/paralelo/eliminar', 'paraleloController@eliminar');
                }else 
                if($ruta == '/paralelo/editar'){
                    Route::post('/paralelo/editar', 'paraleloController@editar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                break;
 
        }
    }
}
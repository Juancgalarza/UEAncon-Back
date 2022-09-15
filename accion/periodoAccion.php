<?php

require_once 'app/error.php';

class PeriodoAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/periodo/listar' && $params) {
                    Route::get('/periodo/listar/:id', 'periodoController@listarId',$params);
                }else
                if ($ruta == '/periodo/listar') {
                    Route::get('/periodo/listar', 'periodoController@listar');
                }else
                if ($ruta == '/periodo/datatable') {
                    Route::get('/periodo/datatable', 'periodoController@dataTable');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
                break;

            case 'post':
                if ($ruta == '/periodo/save') {
                    Route::post('/periodo/save', 'periodoController@guardar');
                }else 
                if($ruta == '/periodo/eliminar'){
                    Route::post('/periodo/eliminar', 'periodoController@eliminar');
                }else 
                if($ruta == '/periodo/editar'){
                    Route::post('/periodo/editar', 'periodoController@editar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                break;
 
        }
    }
}
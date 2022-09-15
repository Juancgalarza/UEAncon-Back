<?php

require_once 'app/error.php';

class RolAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/rol') {
                    Route::get('/rol/listar', 'rolController@listar');
                } else
                if ($ruta == '/rol/listar') {
                    Route::get('/rol/listar', 'rolController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
                break;

            case 'post':
            
                break;

            case 'delete':
                break;  
        }
    }
}

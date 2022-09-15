<?php

require_once 'app/error.php';

class ParcialAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/parcial/listar' && $params) {
                    Route::get('/parcial/listar/:id', 'parcialController@listarId',$params);
                }else
                if ($ruta == '/parcial/listar') {
                    Route::get('/parcial/listar', 'parcialController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
            break;
        }
    }
}
<?php

require_once 'app/error.php';

class QuimestreAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/quimestre/listar' && $params) {
                    Route::get('/quimestre/listar/:id', 'quimestreController@listarId',$params);
                }else
                if ($ruta == '/quimestre/listar') {
                    Route::get('/quimestre/listar', 'quimestreController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
            break;
        }
    }
}
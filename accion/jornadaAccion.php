<?php

require_once 'app/error.php';

class JornadaAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/jornada/listar') {
                    Route::get('/jornada/listar', 'jornadaController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
                break;
        }
    }
}

<?php

require_once 'app/error.php';

class Tipo_ActividadesAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/tipo_actividades/listar') {
                    Route::get('/tipo_actividades/listar', 'tipo_actividadesController@listar');
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

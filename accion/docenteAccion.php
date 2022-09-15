<?php

require_once 'app/error.php';

class DocenteAccion
{

    public function __construct()
    {
        //echo "Soy la clase acciondocente<br>";
    }

    //Configurar rutas y controllers
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/docente/listar' && $params) {
                    Route::get('/docente/listar/:id', 'docenteController@listarId',$params);
                } else
                if ($ruta == '/docente/contar') {
                    Route::get('/docente/contar', 'docenteController@contar');
                } else
                if ($ruta == '/docente/datatable') {
                    Route::get('/docente/datatable', 'docenteController@dataTable');
                }else
                if($ruta == '/docente/list'){
                    Route::get('/docente/list', 'docenteController@listUsers');
                }
                else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                break;

            case 'post':
                if ($ruta == '/docente/login') {
                    Route::post('/docente/login', 'docenteController@login2');
                } else
                if ($ruta == '/docente/save') {
                    Route::post('/docente/save', 'docenteController@guardar');
                }else
                if ($ruta == '/docente/fichero') {
                    Route::post('/docente/fichero', 'docenteController@subirFichero', true);
                }else 
                if($ruta == '/docente/editar'){
                    Route::post('/docente/editar', 'docenteController@editar');
                }else 
                if($ruta == '/docente/eliminar'){
                    Route::post('/docente/eliminar', 'docenteController@eliminar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                break;

        }

    }

}
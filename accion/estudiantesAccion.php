<?php

require_once 'app/error.php';

class EstudiantesAccion
{

    public function __construct()
    {
        //echo "Soy la clase accionestudiantes<br>";
    }

    //Configurar rutas y controllers
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/estudiantes/listar' && $params) {
                    Route::get('/estudiantes/listar/:id', 'estudiantesController@listarId',$params);
                } else
                if ($ruta == '/estudiantes/contar') {
                    Route::get('/estudiantes/contar', 'estudiantesController@contar');
                } else
                if ($ruta == '/estudiantes/verdocentestudiantes' && $params) {
                    Route::get('/estudiantes/verdocentestudiantes/:curso_id/:paralelo_id', 'estudiantesController@verdocentestudiantes', $params);
                }else
                if ($ruta == '/estudiantes/estudianteCalificar' && $params) {
                    Route::get('/estudiantes/estudianteCalificar/:estudiante_id/:curso_id/:paralelo_id', 'estudiantesController@estudianteCalificar', $params);
                } else
                if ($ruta == '/estudiantes/datatable') {
                    Route::get('/estudiantes/datatable', 'estudiantesController@dataTable');
                }else
                if ($ruta == '/estudiantes/datatableEstudianteReporte') {
                    Route::get('/estudiantes/datatableEstudianteReporte', 'estudiantesController@dataTableEstudianteReporte');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                break;

            case 'post':
                if($ruta == '/estudiantes/editar'){
                    Route::post('/estudiantes/editar', 'estudiantesController@editar');
                }else 
                if($ruta == '/estudiantes/eliminar'){
                    Route::post('/estudiantes/eliminar', 'estudiantesController@eliminar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                break;

        }

    }

}
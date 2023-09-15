<?php
require_once 'app/error.php';

class ExamenAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                /* if ($ruta == '/examen/calificarExamenEstudiante') {
                    Route::get('/examen/calificarExamenEstudiante', 'examenController@calificarExamenEstudiante');
                }
                else {
                    ErrorClass::e(404, "La ruta no existe");
                } */
            break;

            case 'post':
                if ($ruta == '/examen/calificarExamenEstudiante') {
                    Route::post('/examen/calificarExamenEstudiante', 'examenController@calificarExamenEstudiante');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

        }
    }
}
<?php

require_once 'app/error.php';

class MateriaAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/materia/listar' && $params) {
                    Route::get('/materia/listar/:id', 'materiaController@listarId',$params);
                }else
                if ($ruta == '/materia/listar') {
                    Route::get('/materia/listar', 'materiaController@listar');
                }else
                if ($ruta == '/materia/datatable') {
                    Route::get('/materia/datatable', 'materiaController@dataTable');
                }else
                if ($ruta == '/materia/datatableAsignar') {
                    Route::get('/materia/datatableAsignar', 'materiaController@dataTableAsignar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
                break;

            case 'post':
                if ($ruta == '/materia/save') {
                    Route::post('/materia/save', 'materiaController@guardar');
                }else 
                if($ruta == '/materia/eliminar'){
                    Route::post('/materia/eliminar', 'materiaController@eliminar');
                }else 
                if($ruta == '/materia/editar'){
                    Route::post('/materia/editar', 'materiaController@editar');
                }
                break;
 
        }
    }
}
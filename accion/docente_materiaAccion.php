<?php

require_once 'app/error.php';

class Docente_MateriaAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/docente_materia/listar' && $params) {
                    Route::get('/docente_materia/listar/:id', 'docente_materiaController@listarId',$params);
                }else
                if ($ruta == '/docente_materia/listar') {
                    Route::get('/docente_materia/listar', 'docente_materiaController@listar');
                }else
                if ($ruta == '/docente_materia/datatable') {
                    Route::get('/docente_materia/datatable', 'docente_materiaController@dataTable');
                }else
                if ($ruta == '/docente_materia/materiaCursoParalelo'&& $params) {
                    Route::get('/docente_materia/materiaCursoParalelo/:docente_id', 'docente_materiaController@listarmateriacurso', $params);
                }else
                if ($ruta == '/docente_materia/datatableAsignaciones' && $params) {
                    Route::get('/docente_materia/datatableAsignaciones/:periodo_id', 'docente_materiaController@dataTableAsignaciones',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
                break;

            case 'post':
                if ($ruta == '/docente_materia/save') {
                    Route::post('/docente_materia/save', 'docente_materiaController@guardar');
                }else 
                if($ruta == '/docente_materia/eliminar'){
                    Route::post('/docente_materia/eliminar', 'docente_materiaController@eliminar');
                }else 
                if($ruta == '/docente_materia/editar'){
                    Route::post('/docente_materia/editar', 'docente_materiaController@editar');
                }
                break;
                case 'delete':
                    if ($params) {
                        if ($ruta == '/docente_materia/eliminarDocenteMateria' && $params) {
                            Route::delete('/docente_materia/eliminarDocenteMateria/:id', 'docente_materiaController@eliminarDocenteMateria', $params);
                        } 
                    } else {
                        ErrorClass::e(400, 'No ha enviado parámetros por la url');
                    }
                break;
 
        }
    }
}
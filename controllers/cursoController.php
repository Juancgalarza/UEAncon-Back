<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/cursoModel.php';

class CursoController
{
    private $cors;
  
    public function __construct()
    {
        $this->cors = new Cors();
       
    }

    public function listar()
    {
        $this->cors->corsJson();

        $cursos = Curso::where('estado', 'A')->get();
        $response = [];

        if (count($cursos) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen cursos',
                'curso' => $cursos,
            ];
        } else {
            $response = [
                'status' => false,
                'cursos' => null,
                'mensaje' => 'No existen cursos',
            ];
        }
        echo json_encode($response);
    }

    public function listarId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $curso = Curso::find($id);
        $response = [];

        if ($curso) {
            $curso->jornada;
            $response = [
                'status' => true,
                'curso' => $curso,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el curso',
                'curso' => null,
            ];
            
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $cursoRequest = $request->input("curso");

        if ($cursoRequest) {
            $existeCurso = Curso::where('nombre_curso', $cursoRequest->nombre_curso)->get()->first();

            if ($existeCurso) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El Curso ya existe',
                    'curso' => null,
                ];
            } else {
                $nuevoCurso = new Curso();
                $nuevoCurso->jornada_id = intval($cursoRequest->jornada_id);
                $nuevoCurso->nombre_curso = ucfirst($cursoRequest->nombre_curso);
                $nuevoCurso->estado = 'A';

                if ($nuevoCurso->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'El Curso se ha guardado correctamente',
                        'curso' => $nuevoCurso,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El Curso no se puede guardar',
                        'curso' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'curso' => null,
            ];
        }
        echo json_encode($response);
    }

    public function dataTable()
    {
        $this->cors->corsJson();

        $cursos = Curso::where('estado', 'A')->orderBy('id')->get();
     
        $data = [];    $i = 1;

        foreach ($cursos as $c) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="editarCurso(' . $c->id . ')">
                                <i class="fa fa-pencil-square fa-lg"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarCurso(' . $c->id . ')">
                                <i class="fa fa-trash fa-lg"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $c->nombre_curso,
                2 => $c->jornada->jornada,
                3 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];
        echo json_encode($result);
    }

    public function dataTableAsignar(){
        $this->cors->corsJson();

        $cursos = Curso::where('estado', 'A')->orderBy('id')->get();
     
        $data = [];    $i = 1;

        foreach ($cursos as $c) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="seleccionarCurso(' . $c->id . ')">
                            <i class="fa fa-check fa-lg"></i>
                            </button>
                       
                        </div>';

            $data[] = [
                0 => $i,
                1 => $c->nombre_curso,
                2 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];
        echo json_encode($result);

    }

    public function eliminar(Request $request){
        $this->cors->corsJson();
        $cursoRequest = $request->input('curso');
        $id = intval($cursoRequest->id);

        $cursos = Curso::find($id);
        $response = [];

        if($cursos){
            $cursos->estado = 'I';
            $cursos->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el Curso', 
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No se ha podido eliminar el Curso', 
            ];
        }
        echo json_encode($response);
    }

    public function editar(Request $request){
        
        $this->cors->corsJson();   
        $perRequest = $request->input('curso');

        $id = intval($perRequest->id);
        $nombre_curso = ucfirst($perRequest->nombre_curso);
        $jornada_id = intval($perRequest->jornada_id);

        $response = [];       
        $cur = Curso::find($id);
        if($perRequest){
            if($cur){
                $cur->jornada_id = $jornada_id;
                $cur->nombre_curso = $nombre_curso;
                $cur->save();  

                $response = [
                    'status' => true,
                    'mensaje' => 'El Curso se ha actualizado',
                    'curso' => $cur,
                ];
            }else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el Curso',
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos...!!'
            ];
        }
        echo json_encode($response);
    }

}

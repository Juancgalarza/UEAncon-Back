<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/curso_materiaModel.php';
require_once 'models/cursoModel.php';
require_once 'models/materiaModel.php';

class Curso_MateriaController
{

    private $cors;


    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $datos = $request->input('curso_materia');
        $response = [];

        if ($datos) {
            $curso_id = intval($datos->curso_id);
            $materia_id = intval($datos->materia_id);

            $nuevoCursoMateria = new Curso_Materia();
            $nuevoCursoMateria->curso_id = $curso_id;
            $nuevoCursoMateria->materia_id = $materia_id;
            $nuevoCursoMateria->estado = 'A';

            $existeMateria = Curso_Materia::where('materia_id', $materia_id)->where('curso_id',$curso_id)->get()->first();

            if ($existeMateria) {
                $response = [
                    'status' => false,
                    'mensaje' => 'La materia ya fue asignada',
                ];
            } else {
                if ($nuevoCursoMateria->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'Se ha realizado la Asignación',
                        'curso_materia' => $nuevoCursoMateria,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo realizar la Asiganción',
                        'curso_materia' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No ha enviado datos',
                'curso_materia' => null,
            ];
        }
        echo json_encode($response);
    }

    public function dataTableAsignaciones()
    {
        $this->cors->corsJson();

        $dataCursoMateria = Curso_Materia::where('estado', 'A')->orderBy('id')->get();
     
        $data = [];    $i = 1;

        foreach ($dataCursoMateria as $p) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-danger btn-sm" onclick="eliminarCursoMateria(' . $p->id . ')">
                                <i class="fa fa-trash fa-lg"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $p->curso->nombre_curso,
                2 => $p->materia->nombre_materia,
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

    public function eliminarCursoMateria($params) 
    {
        $this->cors->corsJson(); 
        $id = intval($params['id']);
        $curNat = Curso_Materia::find($id);
        $response = [];

        if($curNat->delete()){
            $response = [
                'status' => true,
                'mensaje' => 'Se ha borrado la Asignación',
            ];
        }else {
            $response = [
                'status' => false,
                'mensaje' => 'No se pudo borrar la Asignación',
            ];
        }
        echo json_encode($response);
    }

    public function datatableMateriaxCurso($params){
        $this->cors->corsJson();
        $curso_id = intval($params['curso_id']);

        $dataM = Curso_Materia::where('curso_id',$curso_id)->where('estado', 'A')->orderBy('id')->get();
     
        $data = [];    $i = 1;

        foreach ($dataM as $md) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="seleccionarMateria(' . $md->materia_id . ')">
                            <i class="fa fa-check fa-lg"></i>
                            </button>
                       
                        </div>';

            $data[] = [
                0 => $i,
                1 => $md->materia->nombre_materia,
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

}

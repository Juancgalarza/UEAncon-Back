<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/docente_materiaModel.php';
require_once 'models/docenteModel.php';
require_once 'models/materiaModel.php';
require_once 'models/personaModel.php';

class Docente_MateriaController
{

    private $cors;


    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $datos = $request->input('docente_materia');
        $response = [];

        if ($datos) {
            $periodo_id = intval($datos->periodo_id);
            $docente_id = intval($datos->docente_id);
            $materia_id = intval($datos->materia_id);
            $curso_id = intval($datos->curso_id);
            $paralelo_id = intval($datos->paralelo_id);

            $nuevoDocenteMateria = new Docente_Materia();
            $nuevoDocenteMateria->periodo_id = $periodo_id;
            $nuevoDocenteMateria->docente_id = $docente_id;
            $nuevoDocenteMateria->materia_id = $materia_id;
            $nuevoDocenteMateria->curso_id = $curso_id;
            $nuevoDocenteMateria->paralelo_id = $paralelo_id;
            $nuevoDocenteMateria->estado = 'A';

            $existeMateria = Docente_Materia::where('periodo_id', $periodo_id)->where('materia_id', $materia_id)->where('docente_id',$docente_id)->where('curso_id',$curso_id)->where('paralelo_id',$paralelo_id)->get()->first();

            if ($existeMateria) {
                $response = [
                    'status' => false,
                    'mensaje' => 'La materia ya fue asignada',
                ];
            } else {
                $materias_asignadas = Docente::find($docente_id);
                if ($materias_asignadas->materias_asignadas == 4) {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El docente seleccionado ya tiene un límite de materias asignadas',
                    ];
                } else {
                $materias_asignadas->materias_asignadas += 1;
                $materias_asignadas->save();
                    if ($nuevoDocenteMateria->save()) {
                        $response = [
                            'status' => true,
                            'mensaje' => 'Se ha realizado la Asignación',
                            'docente_materia' => $nuevoDocenteMateria,
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'mensaje' => 'No se pudo realizar la Asiganción',
                            'docente_materia' => null,
                        ];
                    }    
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

    public function dataTableAsignaciones($params)
    {
        $this->cors->corsJson();
        $periodo_id = intval($params['periodo_id']);
        $dataDocenteMateria = Docente_Materia::where('periodo_id',$periodo_id)->where('estado', 'A')->orderBy('id')->get();
     
        $data = [];    $i = 1;

        foreach ($dataDocenteMateria as $p) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-danger btn-sm" onclick="eliminarDocenteMateria(' . $p->id . ')">
                                <i class="fa fa-trash fa-lg"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $p->docente->persona->nombres.' '.$p->docente->persona->apellidos,
                2 => $p->materia->nombre_materia,
                3 => $p->curso->nombre_curso,
                4 => $p->paralelo->tipo,
                5 => $botones,
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

    public function eliminarDocenteMateria($params) 
    {
        $this->cors->corsJson(); 
        $id = intval($params['id']);
        $docMat = Docente_Materia::find($id);
        $response = [];

        if($docMat->delete()){
            $response = [
                'status' => true,
                'mensaje' => 'Se ha borrado la Asignación',
                'docente_materia' => $docMat,
            ];
        }else {
            $response = [
                'status' => false,
                'mensaje' => 'No se pudo borrar la Asignación',
            ];
        }
        echo json_encode($response);
    }

    public function listarmateriacurso($params){
        $this->cors->corsJson();
        $docente_id = intval($params['docente_id']);
        $docente_materia = Docente_Materia::where('docente_id',$docente_id)->where('estado','A')->get();
        $response = [];

        if (count($docente_materia) > 0) {
            foreach ($docente_materia as $da) {
                $da->docente->persona;
                $da->materia->nombre_materia;
                $da->curso->nombre_curso;
                $da->paralelo->tipo;
            }
            $response = [
                'status' => true,
                'docente_materia' => $docente_materia,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el docente',
                'docente_materia' => null,
            ];
            
        }
        echo json_encode($response);
    }

}

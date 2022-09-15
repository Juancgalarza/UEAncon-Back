<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/materiaModel.php';

class MateriaController
{
    private $cors;
  
    public function __construct()
    {
        $this->cors = new Cors();
       
    }

    public function listar()
    {
        $this->cors->corsJson();

        $materias = Materia::where('estado', 'A')->get();
        $response = [];

        if (count($materias) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen materias',
                'materia' => $materias,
            ];
        } else {
            $response = [
                'status' => false,
                'materia' => null,
                'mensaje' => 'No existen materias',
            ];
        }
        echo json_encode($response);
    }

    public function listarId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $materia = Materia::find($id);
        $response = [];

        if ($materia) {
            $response = [
                'status' => true,
                'materia' => $materia,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el materia',
                'materia' => null,
            ];
            
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $materiaRquest = $request->input("materia");

        if ($materiaRquest) {
            $existeMateria = Materia::where('nombre_materia', $materiaRquest->nombre_materia)->get()->first();

            if ($existeMateria) {
                $response = [
                    'status' => false,
                    'mensaje' => 'La Materia ya existe',
                    'materia' => null,
                ];
            } else {
                $nuevaMateria = new Materia();
                $nuevaMateria->nombre_materia = ucfirst($materiaRquest->nombre_materia);
                $nuevaMateria->estado = 'A';

                if ($nuevaMateria->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'La Materia se ha guardado correctamente',
                        'materia' => $nuevaMateria,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'La Materia no se puede guardar',
                        'materia' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'materia' => null,
            ];
        }
        echo json_encode($response);
    }

    public function dataTable()
    {
        $this->cors->corsJson();

        $materias = Materia::where('estado', 'A')->orderBy('id')->get();
     
        $data = [];    $i = 1;

        foreach ($materias as $m) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="editarMateria(' . $m->id . ')">
                                <i class="fa fa-pencil-square fa-lg"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarMateria(' . $m->id . ')">
                                <i class="fa fa-trash fa-lg"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $m->nombre_materia,
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
        $materiaRequest = $request->input('materia');
        $id = intval($materiaRequest->id);

        $materia = Materia::find($id);
        $response = [];

        if($materia){
            $materia->estado = 'I';
            $materia->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado la Materia', 
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No se ha podido eliminar  Materia', 
            ];
        }
        echo json_encode($response);
    }

    public function editar(Request $request){
        
        $this->cors->corsJson();   
        $mastRequest = $request->input('materia');

        $id = intval($mastRequest->id);
        $nombre_materia = ucfirst($mastRequest->nombre_materia);

        $response = [];       
        $mat = Materia::find($id);
        if($mastRequest){
            if($mat){
                $mat->nombre_materia = $nombre_materia;
                $mat->save();  

                $response = [
                    'status' => true,
                    'mensaje' => 'La Materia se ha actualizado',
                    'materia' => $mat,
                ];
            }else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el Materia',
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

    public function dataTableAsignar()
    {
        $this->cors->corsJson();

        $materias = Materia::where('estado', 'A')->orderBy('id')->get();
     
        $data = [];    $i = 1;

        foreach ($materias as $m) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="seleccionarMateria(' . $m->id . ')">
                                <i class="fa fa-check fa-lg"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $m->nombre_materia,
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

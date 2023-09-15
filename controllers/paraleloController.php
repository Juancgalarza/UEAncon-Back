<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/paraleloModel.php';

class ParaleloController
{
    private $cors;
  
    public function __construct()
    {
        $this->cors = new Cors();
       
    }

    public function listar()
    {
        $this->cors->corsJson();

        $paralelos = Paralelo::where('estado', 'A')->get();
        $response = [];

        if (count($paralelos) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen paralelos',
                'paralelo' => $paralelos,
            ];
        } else {
            $response = [
                'status' => false,
                'paralelo' => null,
                'mensaje' => 'No existen paralelos',
            ];
        }
        echo json_encode($response);
    }

    public function listarId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $paralelo = Paralelo::find($id);
        $response = [];

        if ($paralelo) {
            $response = [
                'status' => true,
                'paralelo' => $paralelo,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el paralelo',
                'paralelo' => null,
            ];
            
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $paraleloRequest = $request->input("paralelo");

        if ($paraleloRequest) {
            $existeParalelo = Paralelo::where('tipo', $paraleloRequest->tipo)->get()->first();

            if ($existeParalelo) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El Paralelo ya existe',
                    'paralelo' => null,
                ];
            } else {
                $nuevoParalelo = new Paralelo();
                $nuevoParalelo->tipo = ucfirst($paraleloRequest->tipo);
                $nuevoParalelo->capacidad = intval($paraleloRequest->capacidad);
                $nuevoParalelo->total_estudiantes = 0;
                $nuevoParalelo->estado = 'A';

                if ($nuevoParalelo->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'El Paralelo se ha guardado correctamente',
                        'paralelo' => $nuevoParalelo,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El Paralelo no se puede guardar',
                        'paralelo' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'paralelo' => null,
            ];
        }
        echo json_encode($response);
    }

    public function dataTable()
    {
        $this->cors->corsJson();

        $paralelos = Paralelo::where('estado', 'A')->orderBy('id')->get();
     
        $data = [];    $i = 1;

        foreach ($paralelos as $p) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="editarParalelo(' . $p->id . ')">
                                <i class="fa fa-pencil-square fa-lg"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarParalelo(' . $p->id . ')">
                                <i class="fa fa-trash fa-lg"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $p->tipo,
                2 => $p->capacidad,
                3 => $p->total_estudiantes,
                4 => $botones,
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
        $paraleloRequest = $request->input('paralelo');
        $id = intval($paraleloRequest->id);

        $paralelos = Paralelo::find($id);
        $response = [];

        if($paralelos){
            $paralelos->estado = 'I';
            $paralelos->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el Paralelo', 
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No se ha podido eliminar el Paralelo', 
            ];
        }
        echo json_encode($response);
    }

    public function editar(Request $request){
        
        $this->cors->corsJson();   
        $perRequest = $request->input('paralelo');

        $id = intval($perRequest->id);
        $tipo = ucfirst($perRequest->tipo);

        $response = [];       
        $par = Paralelo::find($id);
        if($perRequest){
            if($par){
                $par->tipo = $tipo;
                $par->capacidad = $perRequest->capacidad;
                $par->save();  

                $response = [
                    'status' => true,
                    'mensaje' => 'El Paralelo se ha actualizado',
                    'paralelo' => $par,
                ];
            }else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el Paralelo',
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

    public function dataTableAsignar(){
        $this->cors->corsJson();

        $paralelos = Paralelo::where('estado', 'A')->orderBy('id')->get();
     
        $data = [];    $i = 1;

        foreach ($paralelos as $p) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="seleccionarParalelo(' . $p->id . ')">
                            <i class="fa fa-check fa-lg"></i>
                            </button>
                       
                        </div>';

            $data[] = [
                0 => $i,
                1 => $p->tipo,
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

<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/periodoModel.php';

class PeriodoController
{
    private $cors;
  
    public function __construct()
    {
        $this->cors = new Cors();
       
    }

    public function listar()
    {
        $this->cors->corsJson();

        $periodos = Periodo::where('estado', 'A')->get();
        $response = [];

        if (count($periodos) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen periodos',
                'periodo' => $periodos,
            ];
        } else {
            $response = [
                'status' => false,
                'periodo' => null,
                'mensaje' => 'No existen periodos',
            ];
        }
        echo json_encode($response);
    }

    public function listarId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $periodo = Periodo::find($id);
        $response = [];

        if ($periodo) {
            $response = [
                'status' => true,
                'periodo' => $periodo,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el periodo',
                'periodo' => null,
            ];
            
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $periodoRequest = $request->input("periodo");

        if ($periodoRequest) {
            $existePeriodo = Periodo::where('periodo', $periodoRequest->periodo)->get()->first();

            if ($existePeriodo) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El Período ya existe',
                    'periodo' => null,
                ];
            } else {
                $nuevoPeriodo = new Periodo();
                $nuevoPeriodo->periodo = $periodoRequest->periodo;
                $nuevoPeriodo->estado = 'A';

                if ($nuevoPeriodo->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'El Período se ha guardado correctamente',
                        'periodo' => $nuevoPeriodo,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El Período no se puede guardar',
                        'periodo' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'periodo' => null,
            ];
        }
        echo json_encode($response);
    }

    public function dataTable()
    {
        $this->cors->corsJson();

        $periodos = Periodo::where('estado', 'A')->orderBy('id')->get();
     
        $data = [];    $i = 1;

        foreach ($periodos as $p) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="editarPeriodo(' . $p->id . ')">
                                <i class="fa fa-pencil-square fa-lg"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarPeriodo(' . $p->id . ')">
                                <i class="fa fa-trash fa-lg"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $p->periodo,
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
        $periodRequest = $request->input('periodo');
        $id = intval($periodRequest->id);

        $periodos = Periodo::find($id);
        $response = [];

        if($periodos){
            $periodos->estado = 'I';
            $periodos->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el Período', 
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No se ha podido eliminar el Período', 
            ];
        }
        echo json_encode($response);
    }

    public function editar(Request $request){
        
        $this->cors->corsJson();   
        $perRequest = $request->input('periodo');

        $id = intval($perRequest->id);
        $periodo = ucfirst($perRequest->periodo);

        $response = [];       
        $per = Periodo::find($id);
        if($perRequest){
            if($per){
                $per->periodo = $periodo;
                $per->save();  

                $response = [
                    'status' => true,
                    'mensaje' => 'El Período se ha actualizado',
                    'periodo' => $per,
                ];
            }else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el Período',
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

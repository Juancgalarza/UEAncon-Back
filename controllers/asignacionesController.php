<?php
require_once 'core/conexion.php';
require_once 'app/helper.php';
require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/asignacionesModel.php';
require_once 'controllers/detalle_asignacionesController.php';

class AsignacionesController
{
    private $cors;
    private $conexion;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
    }

    /* public function listarxId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];

        $ventas = Ventas::find($id);

        if($ventas){
            $ventas->usuarios->personas;
            $ventas->clientes->personas;

            foreach($ventas->detalle_venta as $dv){
                $dv->productos->categorias;
            }
            
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'venta' => $ventas,
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'venta' => null,
            ];
        }
        echo json_encode($response);
    } */

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $asignacionrequest = $request->input('asignaciones');
        $detallesasignacion = $request->input('detalle_asignaciones');

        $response = [];

        if ($asignacionrequest) {
            $asignacionrequest->docente_id = intval($asignacionrequest->docente_id);
            $asignacionrequest->materia_id = intval($asignacionrequest->materia_id);
            $asignacionrequest->estudiante_id = intval($asignacionrequest->estudiante_id);
            $asignacionrequest->curso_id = intval($asignacionrequest->curso_id);
            $asignacionrequest->paralelo_id = intval($asignacionrequest->paralelo_id);
            $asignacionrequest->total = doubleval($asignacionrequest->total);

            $nuevaAsignacion = new Asignaciones();
            $nuevaAsignacion->docente_id = $asignacionrequest->docente_id;
            $nuevaAsignacion->materia_id = $asignacionrequest->materia_id;
            $nuevaAsignacion->estudiante_id = $asignacionrequest->estudiante_id;
            $nuevaAsignacion->curso_id = $asignacionrequest->curso_id;
            $nuevaAsignacion->paralelo_id = $asignacionrequest->paralelo_id;
            $nuevaAsignacion->total = $asignacionrequest->total;
            $nuevaAsignacion->estado = 'A';

            if ($nuevaAsignacion->save()) {

                $detalleController = new Detalle_AsignacionesController();
                $extra = $detalleController->guardar($nuevaAsignacion->id, $detallesasignacion);

                $response = [
                    'status' => true,
                    'mensaje' => 'La asignación se genero correctamente',
                    'asignacion' => $nuevaAsignacion,
                    'detalle' => $extra,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'La asignación no se puede guardar',
                    'asignacion' => null,
                    'detalle' => null,
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'asignacion' => null,
                'detalle' => null,
            ];
        }
        echo json_encode($response);
    }


    public function reportexParcial($params)
    {
        $this->cors->corsJson();
        $estudiante_id = intval($params['estudiante_id']);
        $data = Asignaciones::where('estudiante_id', $estudiante_id)->where('estado', 'A')->get();
        $response = [];
        $nuevoarray = [];

        if (count($data) > 0) {
            foreach ($data as $d) {
                $d->materia->nombre_materia;
                $d->curso->nombre_curso;
                $d->paralelo->tipo;
                $d->detalle_asignaciones;
                $materia = $d->materia->nombre_materia;

                foreach ($d->detalle_asignaciones as $det) {
                    $det->parcial;
                    $det->quimestre;
                    $det->tipo_actividades;
                }
            }
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'data' => [
                    'tabla' => $data,
                ],
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra la data',
                'data' => null,
            ];
        }
        echo json_encode($response);
    }

}

<?php
require_once 'core/conexion.php';
require_once 'app/helper.php';
require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/calificacionesModel.php';
require_once 'models/detalle_calificacionesModel.php';
require_once 'models/estudianteModel.php';
require_once 'controllers/detalle_calificacionesController.php';

class CalificacionesController
{
    private $cors;
    private $conexion;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $calificacionrequest = $request->input('calificaciones');
        $detallecalificacion = $request->input('detalle_calificaciones');

        $response = [];

        if ($calificacionrequest) {
            $calificacionrequest->docente_id = intval($calificacionrequest->docente_id);
            $calificacionrequest->materia_id = intval($calificacionrequest->materia_id);
            $calificacionrequest->curso_id = intval($calificacionrequest->curso_id);
            $calificacionrequest->paralelo_id = intval($calificacionrequest->paralelo_id);
            $calificacionrequest->promedio_total = doubleval($calificacionrequest->promedio_total);

            $nuevaCalificacion = new Calificaciones();
            $nuevaCalificacion->docente_id = $calificacionrequest->docente_id;
            $nuevaCalificacion->materia_id = $calificacionrequest->materia_id;
            $nuevaCalificacion->curso_id = $calificacionrequest->curso_id;
            $nuevaCalificacion->paralelo_id = $calificacionrequest->paralelo_id;
            $nuevaCalificacion->promedio_total = $calificacionrequest->promedio_total;
            $nuevaCalificacion->estado = 'A';

            //echo json_encode($detallecalificacion[0]->parcial_id); die();
            //$exis_parcial = Detalle_Calificaciones::where('parcial_id', $detallecalificacion[0]->parcial_id)->get()->first();
            //$exis_estudiante = Calificaciones::where('estudiante_id', $calificacionrequest->estudiante_id)->where('materia_id', $calificacionrequest->materia_id)->get()->first();
            /* if ($exis_parcial && $exis_estudiante) {
                $response = [
                    'status' => false,
                    'mensaje' => 'Ya se asignaron calificaciones al Parcial Seleccionado',
                    'calificacion' => null,
                    'detalle' => null,
                ];
            } else {
            } */
            if ($nuevaCalificacion->save()) {

                $detalleController = new Detalle_CalificacionesController();
                $extra = $detalleController->guardar($nuevaCalificacion->id, $detallecalificacion);

                $response = [
                    'status' => true,
                    'mensaje' => 'Las Calificaciones se asignaron correctamente',
                    'calificacion' => $nuevaCalificacion,
                    'detalle' => $extra,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'Las Calificaciones no se puede guardar',
                    'calificacion' => null,
                    'detalle' => null,
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'calificacion' => null,
                'detalle' => null,
            ];
        }
        echo json_encode($response);
    }


    /* public function reportexParcial($params)
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
    } */

    public function desgloseCalificacion($params)
    {
        $this->cors->corsJson();
        $docente_id = intval($params['docente_id']);
        $data = Calificaciones::where('docente_id', $docente_id)->where('estado', 'A')->get();
        $response = [];

        if (count($data) > 0) {
            $nuevoArray = [];
            foreach ($data as $d) {
                foreach ($d->detalle_calificaciones as $det) {
                    $parcial = $det->parcial;
                }
                $aux = [
                    'estudiante_id' => $d->estudiante_id,
                    'materia' => $d->materia->nombre_materia,
                    'curso' => $d->curso->nombre_curso,
                    'paralelo' =>  $d->paralelo->tipo,
                    'estudiante' => $det->estudiante->persona,
                    'detalle' => $det,
                ];
                $nuevoArray[] = (object)$aux;
            }

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'data' => $nuevoArray,
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

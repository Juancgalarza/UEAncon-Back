<?php
require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/detalle_asignacionesModel.php';
require_once 'models/asignacionesModel.php';
require_once 'models/parcialModel.php';
require_once 'models/quimestreModel.php';

class Detalle_AsignacionesController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardar($asignaciones_id, $detalles=[]){
        $response = [];
        
        if(count($detalles) > 0){
            foreach($detalles as $det){
                $nuevaventadetalle = new Detalle_Asignaciones();
                $nuevaventadetalle->asignaciones_id = intval($asignaciones_id);
                $nuevaventadetalle->parcial_id = intval($det->parcial_id);
                $nuevaventadetalle->quimestre_id = intval($det->quimestre_id);
                $nuevaventadetalle->calificacion = doubleval($det->calificacion);
                $nuevaventadetalle->tipo_actividades_id = intval($det->tipo_actividades_id);
                $nuevaventadetalle->save();
            }

            $detalleguardar=Detalle_Asignaciones::where('asignaciones_id',$asignaciones_id)->get();
            $response=[
                'status'=>true,
                'mensaje'=>'Se guardaron los datos',
                'detalle_asignaciones'=>$detalleguardar
            ];
        }else{
            $response=[
                'status' => false,
                'mensaje' => 'No hay productos para guardar',
                'detalle_asignaciones' => null
            ];
        }
        return $response;
    }

    public function reportexParcialQuimestre($params)
    {
        $this->cors->corsJson();
        $parcial_id = intval($params['parcial_id']);
        $quimestre_id = intval($params['quimestre_id']);
        $estudiante_id = intval($params['estudiante_id']);
        $data = Detalle_Asignaciones::where('parcial_id', $parcial_id)->where('quimestre_id', $quimestre_id)->get();
        $dataEstudiante = Asignaciones::where('estudiante_id', $estudiante_id)->where('estado','A')->get();
        $response = [];
        $nuevoarray = [];

        if (count($data) > 0 && count($dataEstudiante) > 0 ) {
            foreach ($dataEstudiante as $d) {
                $d->materia->nombre_materia;
                foreach ($d->detalle_asignaciones as $det) {
                    $det->tipo_actividades->actividad;
                    $det->calificacion;
                }
            }

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'data' => [
                    'tabla' => $dataEstudiante,
                    //'materia' => $dataEstudiante,
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
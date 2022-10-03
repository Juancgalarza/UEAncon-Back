<?php
require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/detalle_calificacionesModel.php';
require_once 'models/calificacionesModel.php';
require_once 'models/parcialModel.php';

class Detalle_CalificacionesController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardar($calificaciones_id, $detalles=[]){
        $response = [];
        
        if(count($detalles) > 0){
            foreach($detalles as $det){
                $nuevaventadetalle = new Detalle_Calificaciones();
                $nuevaventadetalle->calificaciones_id = intval($calificaciones_id);
                $nuevaventadetalle->parcial_id = intval($det->parcial_id);
                $nuevaventadetalle->estudiante_id = intval($det->estudiante_id);
                $nuevaventadetalle->nota1 = doubleval($det->nota1);
                $nuevaventadetalle->nota2 = doubleval($det->nota2);
                $nuevaventadetalle->nota3 = doubleval($det->nota3);
                $nuevaventadetalle->nota4 = doubleval($det->nota4);
                $nuevaventadetalle->nota5 = doubleval($det->nota5);
                $nuevaventadetalle->nota6 = doubleval($det->nota6);
                $nuevaventadetalle->total = doubleval($det->total);
                $nuevaventadetalle->promedio = doubleval($det->promedio);
                $nuevaventadetalle->examen = doubleval($det->examen);
                $nuevaventadetalle->save();
            }

            $detalleguardar=Detalle_Calificaciones::where('calificaciones_id',$calificaciones_id)->get();
            $response=[
                'status'=>true,
                'mensaje'=>'Se guardaron los datos',
                'detalle_calificaciones'=>$detalleguardar
            ];
        }else{
            $response=[
                'status' => false,
                'mensaje' => 'No hay calificaciones para guardar',
                'detalle_calificaciones' => null
            ];
        }
        return $response;
    }

    public function reportexParcial($params)
    {
        $this->cors->corsJson();
        $parcial_id = intval($params['parcial_id']);
        $estudiante_id = intval($params['estudiante_id']);
        $data = Detalle_Calificaciones::where('parcial_id', $parcial_id)->where('estudiante_id', $estudiante_id)->get();
        $response = [];
        $nuevoarray = [];

        if (count($data) > 0 ) {
            foreach ($data as $d) {
                $d->parcial;
                $d->estudiante->persona;
                $d->calificaciones->materia;
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
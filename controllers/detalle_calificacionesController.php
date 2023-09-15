<?php
require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/detalle_calificacionesModel.php';
require_once 'models/calificacionesModel.php';
require_once 'models/parcialModel.php';
require_once 'models/examenModel.php';

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
                $nuevaventadetalle->nota1 = doubleval($det->nota1);
                $nuevaventadetalle->nota2 = doubleval($det->nota2);
                $nuevaventadetalle->nota3 = doubleval($det->nota3);
                $nuevaventadetalle->nota4 = doubleval($det->nota4);
                $nuevaventadetalle->nota5 = doubleval($det->nota5);
                $nuevaventadetalle->nota6 = doubleval($det->nota6);
                $nuevaventadetalle->total = doubleval($det->total);
                $nuevaventadetalle->promedio = doubleval($det->promedio);
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

    public function reporteQuimestral($params)
    {
        $this->cors->corsJson();
        $quimestre_id = intval($params['quimestre_id']);
        $estudiante_id = intval($params['estudiante_id']);
        $data = Detalle_Calificaciones::where('quimestre_id',$quimestre_id)->where('estudiante_id', $estudiante_id)->get();
        $response = [];

        if (count($data) > 0 ) {
            $dataCal = [];
            foreach ($data as $d) {
                $parcial_id = $d->parcial_id;
                $parcial = $d->parcial->parcial;
                $promedio = $d->promedio;
                $examen = $d->examen;

                $aux = [
                    'parcial_id' => $parcial_id,
                    'parcial' => $parcial,
                    'promedio' => $promedio,
                    'examen' => $examen
                ];
                $dataCal[] = (object)$aux;
            }

            $acumNotasP1 = 0; $acumNotasP2 = 0; $acumNotasP3 = 0; $dataCalExamenes = [];
            $contNotasP1 = 0; $contNotasP2 = 0; $contNotasP3 = 0;
            $promNotasP1 = 0; $promNotasP2 = 0; $promNotasP3 = 0;
            foreach ($dataCal as $dc) {
                if ($dc->parcial_id == 1) {
                    $contNotasP1 ++;
                    $acumNotasP1 += $dc->promedio;
                    $promNotasP1 = $acumNotasP1 / $contNotasP1;
                } else if ($dc->parcial_id == 2) {
                    $contNotasP2 ++;
                    $acumNotasP2 += $dc->promedio;
                    $promNotasP2 = $acumNotasP2 / $contNotasP2;
                } else if ($dc->parcial_id == 3) {
                    $contNotasP3 ++;
                    $acumNotasP3 += $dc->promedio;
                    $promNotasP3 = $acumNotasP3 / $contNotasP3;
                }
            }

        $examen = Examen::where('quimestre_id',$quimestre_id)->where('estudiante_id',$estudiante_id)->get();
        foreach ($examen as $ex) {
            $aux = [
                'materia' => $ex->materia->nombre_materia,
                'examen' => $ex->nota
            ];
            $dataCalExamenes[] = (object)$aux;
        }

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'data' => [
                    'dataExamenes' => $dataCalExamenes,
                    'promParcial1' => round($promNotasP1,2),
                    'promParcial2' => round($promNotasP2,2),
                    'promParcial3' => round($promNotasP3,2),
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

    public function reporteQuimestral2($params)
    {
        $this->cors->corsJson();
        $quimestre_id = intval($params['quimestre_id']);
        $estudiante_id = intval($params['estudiante_id']);
        $data = Detalle_Calificaciones::where('quimestre_id',$quimestre_id)->where('estudiante_id', $estudiante_id)->get();
        $response = [];
        
        if (count($data) > 0 ) {
            $dataCal = []; $nparcial1 = 0; $nparcial2 = 0; $nparcial3 = 0;
            foreach ($data as $d) {
                $parcial_id = $d->parcial_id;
                $quimestre_id = $d->quimestre_id;
                $estudiante_id = $d->estudiante_id;
                $examen = $d->quimestre->examen;

                foreach ($examen as $e) {
                    $nota = $e->nota;
                }
                
                $parcial = $d->parcial->parcial;
                $materia = $d->calificaciones->materia->nombre_materia;
                
                $aux = [
                    'parcial_id' => $parcial_id,
                    'quimestre_id' => $quimestre_id,
                    'estudiante_id' => $estudiante_id,
                    'promedio' => $d->promedio,
                    'materia' => $d->calificaciones->materia->nombre_materia,
                    'examen' => $nota,
                    'materia' => $materia, 
                ];
                $dataCal[] = (object)$aux; 
            }
            //echo json_encode($dataCal); die();
            
            $dataCalExamenes = [];
            
            $examen = Examen::where('quimestre_id',$quimestre_id)->where('estudiante_id',$estudiante_id)->get();
            
            foreach ($dataCal as $dc) {
                
                if ($dc->parcial_id == 1) {
                    $nparcial1 = $dc->promedio;
                }else 
                if ($dc->parcial_id == 2) {
                    $nparcial2 = $dc->promedio;
                }else 
                if ($dc->parcial_id == 3) {
                    $nparcial3 = $dc->promedio;
                }

                foreach ($examen as $ex) {
                    $notae = $ex->nota;
                }
            }
            $aux = [
                'materia' => $ex->materia->nombre_materia,
                'parcial1' => $nparcial1,
                'parcial2' => $nparcial2,
                'parcial3' => $nparcial3,     
                'examen' => $notae
            ];
            $dataCalExamenes[] = (object)$aux;

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'data' => [
                    'dataFinal' => $dataCalExamenes,
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

    public function reporteQuimestral3($params)
    {
        $this->cors->corsJson();
        $quimestre_id = intval($params['quimestre_id']);
        $estudiante_id = intval($params['estudiante_id']);
        $data = Detalle_Calificaciones::join('quimestre','quimestre_id','=','quimestre.id')
        ->leftJoin('estudiante','estudiante_id','=','estudiante.id')
        ->where('quimestre.id',$quimestre_id)->where('estudiante.id', $estudiante_id)
        ->leftJoin('calificaciones','calificaciones_id','=','calificaciones.id')
        ->join('materia','materia_id','=','materia.id')
        ->selectRaw('parcial_id,nombre_materia,promedio')
        ->get();
        $response = [];
        $examen = Examen::where('quimestre_id',$quimestre_id)->where('estudiante_id',$estudiante_id)->get();

        if (isset($data)) {
            $dataCollection = collect($data);
            $dataCollection->duplicates('nombre_materia');
            $groupedNombreMat = $dataCollection->groupBy('nombre_materia');
            foreach ($examen as $e) {
                $examenf[] = $e->nota;
            }
            $aux = [
                'data' => [
                    'materia' => $groupedNombreMat,
                    'examen' => $examenf
                ]
            ];
        } 
        
        echo json_encode($aux);
    }

    public function reporteQuimestral4($params)
    {
        $this->cors->corsJson();
        $quimestre_id = intval($params['quimestre_id']);
        $estudiante_id = intval($params['estudiante_id']);
        $data = Detalle_Calificaciones::where('quimestre_id',$quimestre_id)->where('estudiante_id', $estudiante_id)->get();
        $response = [];

        
        if (count($data) > 0 ) {
            $dataCal = []; $dataProm = [];
            $nparcial1 = 0; $nparcial2 = 0; $nparcial3 = 0; 
            
            foreach ($data as $d) {
                $parcial_id = $d->parcial_id;
                $quimestre_id = $d->quimestre_id;
                $estudiante_id = $d->estudiante_id;
                $materia = $d->calificaciones->materia->nombre_materia;

                if ($d->parcial_id == 1) {
                    //echo json_encode($da); die();
                    $nparcial1 = $d->promedio;
                } else if ($d->parcial_id == 2) {
                    $nparcial2 = $d->promedio;
                } else if ($d->parcial_id == 3) {
                    $nparcial3 = $d->promedio;
                }

                $aux = [
                    'parcial_id' => $parcial_id,
                    'quimestre_id' => $quimestre_id,
                    'estudiante_id' => $estudiante_id,
                    'materia' => $materia,
                    'parcial1' => $nparcial1,
                    'parcial2' => $nparcial2,
                    'parcial3' => $nparcial3,
                ];
                $dataCal[] = (object)$aux; 
            }

            /* foreach ($dataCal as $da) {
                if ($da->parcial_id == 1) {
                    echo json_encode($da); die();
                    $nparcial1 = $da->promedio;
                } else if ($da->parcial_id == 2) {
                    $nparcial2 = $da->promedio;
                } else if ($da->parcial_id == 3) {
                    $nparcial3 = $da->promedio;
                }
                
                $aux2 = [
                    'quimestre_id' => $da->quimestre_id,
                    'estudiante_id' => $da->estudiante_id,
                    'materia' => $da->materia,
                    'parcial1' => $nparcial1,
                    'parcial2' => $nparcial2,
                    'parcial3' => $nparcial3,
                ];
                $dataProm[] = (object)$aux2; 
            } */
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'data' => [
                    'dataGeneral' => $dataCal,
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
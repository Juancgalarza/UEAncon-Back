<?php
require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/examenModel.php';

class ExamenController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function calificarExamenEstudiante(Request $request){

        $this->cors->corsJson();
        $examenrequest = $request->input('examen');

        if ($examenrequest) {
            $nuevoExamen = new Examen();
            $nuevoExamen->quimestre_id = intval($examenrequest->quimestre_id);
            $nuevoExamen->estudiante_id = intval($examenrequest->estudiante_id);
            $nuevoExamen->materia_id = intval($examenrequest->materia_id);
            $nuevoExamen->nota = doubleval($examenrequest->nota);
            $nuevoExamen->estado = 'A';

            $exis_quimestre = Examen::where('quimestre_id', $examenrequest->quimestre_id)->where('estudiante_id', $examenrequest->estudiante_id)->where('materia_id', $examenrequest->materia_id)->get()->first();

            if ($exis_quimestre) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El estudiante ya tiene calificación de Exámen en el Quimestre Seleccionado',
                    'examen' => null,
                ];
            } else {
                if ($nuevoExamen->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'La Calificación del Exámen se asignó correctamente',
                        'examen' => $nuevoExamen,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'La Calificación no se puede guardar',
                        'examen' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'examen' => null,
            ];
        }
        echo json_encode($response); 
    }
}
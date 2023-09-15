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
            $calificacionrequest->estudiante_id = intval($calificacionrequest->estudiante_id);
            $calificacionrequest->docente_id = intval($calificacionrequest->docente_id);
            $calificacionrequest->materia_id = intval($calificacionrequest->materia_id);
            $calificacionrequest->curso_id = intval($calificacionrequest->curso_id);
            $calificacionrequest->paralelo_id = intval($calificacionrequest->paralelo_id);
            $calificacionrequest->parcial_id = intval($calificacionrequest->parcial_id);
            $calificacionrequest->quimestre_id = intval($calificacionrequest->quimestre_id);
            $calificacionrequest->promedio_parcial = doubleval($calificacionrequest->promedio_parcial);

            $nuevaCalificacion = new Calificaciones();
            $nuevaCalificacion->estudiante_id = $calificacionrequest->estudiante_id;
            $nuevaCalificacion->docente_id = $calificacionrequest->docente_id;
            $nuevaCalificacion->materia_id = $calificacionrequest->materia_id;
            $nuevaCalificacion->curso_id = $calificacionrequest->curso_id;
            $nuevaCalificacion->paralelo_id = $calificacionrequest->paralelo_id;
            $nuevaCalificacion->parcial_id = $calificacionrequest->parcial_id;
            $nuevaCalificacion->quimestre_id = $calificacionrequest->quimestre_id;
            $nuevaCalificacion->promedio_parcial = $calificacionrequest->promedio_parcial;
            $nuevaCalificacion->estado = 'A';

            $exis_registro = Calificaciones::where('estudiante_id', $calificacionrequest->estudiante_id)
                ->where('docente_id', $calificacionrequest->docente_id)
                ->where('materia_id', $calificacionrequest->materia_id)
                ->where('curso_id', $calificacionrequest->curso_id)
                ->where('paralelo_id', $calificacionrequest->paralelo_id)
                ->where('parcial_id', $calificacionrequest->parcial_id)
                ->where('quimestre_id', $calificacionrequest->quimestre_id)
                ->get()->first();
            if ($exis_registro) {
                $response = [
                    'status' => false,
                    'mensaje' => 'Ya se asignaron calificaciones al Parcial Seleccionado',
                    'calificacion' => null,
                    'detalle' => null,
                ];
            } else {
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

    public function reportexParcial($params)
    {
        $this->cors->corsJson();
        $parcial_id = intval($params['parcial_id']);
        $quimestre_id = intval($params['quimestre_id']);
        $estudiante_id = intval($params['estudiante_id']);
        $data = Calificaciones::where('parcial_id', $parcial_id)->where('quimestre_id', $quimestre_id)->where('estudiante_id', $estudiante_id)->get();
        $response = [];
        $nuevoarray = [];

        if (count($data) > 0) {
            foreach ($data as $d) {
                $d->parcial;
                $d->estudiante->persona;
                $d->materia;
                $d->detalle_calificaciones;
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
                }
                $aux = [
                    'estudiante_id' => $d->estudiante_id,
                    'materia' => $d->materia->nombre_materia,
                    'curso' => $d->curso->nombre_curso,
                    'parcial' => $d->parcial->parcial,
                    'paralelo' =>  $d->paralelo->tipo,
                    'estudiante' => $d->estudiante->persona,
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

    public function reporteQuimestral($params)
    {
        $this->cors->corsJson();
        $quimestre_id = intval($params['quimestre_id']);
        $estudiante_id = intval($params['estudiante_id']);
        $response = [];
        $materia = [];
        $data = [];
        $newdata = [];

        $dataMateria = Materia::where('estado', 'A')->get();

        if (count($dataMateria) > 0) {
            foreach ($dataMateria as $key) {

                $calificacion = Calificaciones::where('materia_id', $key->id)->where('quimestre_id', $quimestre_id)->where('estudiante_id', $estudiante_id)->get();

                if (count($calificacion) > 0) {
                    $aux = [
                        'cantidad' => count($calificacion),
                        'materia' => $key->nombre_materia,
                        'calificaciones' => $calificacion,
                        'examen' => $key->examen
                    ];
                    $data[] = $aux;
                }
            }
        } else {
            $aux = [
                'mensaje' => 'No hay datos para procesar',
                'calificaciones' => []
            ];
            $data[] = $aux;
        }


        echo json_encode($data);
    }

    public function reporteAnual($params)
    {

        $this->cors->corsJson();
        $estudiante_id = intval($params['estudiante_id']);
        $response = [];
        $materia = [];
        $data = [];
        $newdata = [];

        $dataMateria = Materia::where('estado', 'A')->get();

        if (count($dataMateria) > 0) {
            foreach ($dataMateria as $key) {

                $calificacion = Calificaciones::where('materia_id', $key->id)->where('estudiante_id', $estudiante_id)->get();

                if (count($calificacion) > 0) {
                    $aux = [
                        'cantidad' => count($calificacion),
                        'materia' => $key->nombre_materia,
                        'calificaciones' => $calificacion,
                        'examen' => $key->examen
                    ];
                    $data[] = $aux;
                }
            }
        } else {
            $aux = [
                'mensaje' => 'No hay datos para procesar',
                'calificaciones' => []
            ];
            $data[] = $aux;
        }


        echo json_encode($data);
    }

    public function reportexParcialDocente($params)
    {
        $this->cors->corsJson();
        $parcial_id = intval($params['parcial_id']);
        $quimestre_id = intval($params['quimestre_id']);
        $materia_id = intval($params['materia_id']);
        $curso_id = intval($params['curso_id']);
        $paralelo_id = intval($params['paralelo_id']);
        $data = Calificaciones::where('parcial_id', $parcial_id)
        ->where('quimestre_id', $quimestre_id)
        ->where('materia_id', $materia_id)
        ->where('curso_id', $curso_id)
        ->where('paralelo_id', $paralelo_id)
        ->get();
        $response = [];
        $nuevoarray = [];

        if (count($data) > 0) {
            foreach ($data as $d) {
                $d->parcial;
                $d->estudiante->persona;
                $d->materia;
                $d->detalle_calificaciones;
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

    public function reporteQuimestralDocente($params)
    {
        $this->cors->corsJson();
        $quimestre_id = intval($params['quimestre_id']);
        $materia_id = intval($params['materia_id']);
        $curso_id = intval($params['curso_id']);
        $paralelo_id = intval($params['paralelo_id']);
        $response = [];
        $materia = [];
        $data = [];
        $newdata = [];

        $dataEstudiante = Estudiante::where('estado', 'A')->get();

        if (count($dataEstudiante) > 0) {
            foreach ($dataEstudiante as $key) {

                $calificacion = Calificaciones::where('estudiante_id',$key->id)
                ->where('materia_id', $materia_id)
                ->where('quimestre_id', $quimestre_id)
                ->where('curso_id', $curso_id)
                ->where('paralelo_id', $paralelo_id)
                ->get();

                if (count($calificacion) > 0) {
                    $examen = Examen::where('materia_id', $materia_id)->where('quimestre_id', $quimestre_id)->get();
                    $aux = [
                        'cantidad' => count($calificacion),
                        'estudiante' => $key->persona,
                        'calificaciones' => $calificacion,
                        'examen' => $examen
                    ];
                    $data[] = $aux;
                }
            }
        } else {
            $aux = [
                'mensaje' => 'No hay datos para procesar',
                'calificaciones' => []
            ];
            $data[] = $aux;
        }

        echo json_encode($data);
    }

    public function reporteAnualDocente($params)
    {
        $this->cors->corsJson();
        $materia_id = intval($params['materia_id']);
        $curso_id = intval($params['curso_id']);
        $paralelo_id = intval($params['paralelo_id']);
        $response = [];
        $materia = [];
        $data = [];
        $newdata = [];

        $dataEstudiante = Estudiante::where('estado', 'A')->get();

        if (count($dataEstudiante) > 0) {
            foreach ($dataEstudiante as $key) {

                $calificacion = Calificaciones::where('estudiante_id',$key->id)
                ->where('materia_id', $materia_id)
                ->where('curso_id', $curso_id)
                ->where('paralelo_id', $paralelo_id)
                ->get();

                if (count($calificacion) > 0) {
                    $examen = Examen::where('materia_id', $materia_id)->get();
                    $aux = [
                        'cantidad' => count($calificacion),
                        'estudiante' => $key->persona,
                        'calificaciones' => $calificacion,
                        'examen' => $examen
                    ];
                    $data[] = $aux;
                }
            }
        } else {
            $aux = [
                'mensaje' => 'No hay datos para procesar',
                'calificaciones' => []
            ];
            $data[] = $aux;
        }

        echo json_encode($data);
    }
}

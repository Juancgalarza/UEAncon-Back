<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/estudianteModel.php';
require_once 'models/personaModel.php';

class EstudiantesController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listarId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $estudiante = Estudiante::find($id);
        $response = [];

        if ($estudiante) {
            $estudiante->persona->sexo;
            $estudiante->curso;
            $estudiante->paralelo;
            $response = [
                'status' => true,
                'estudiante' => $estudiante,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el usuario',
                'estudiante' => null,
            ];
        }
        echo json_encode($response);
    }

    public function dataTable()
    {
        $this->cors->corsJson();

        $estudiantes = Estudiante::where('estado', 'A')->orderBy('id', 'desc')->get();
        $data = [];
        $i = 1;

        foreach ($estudiantes as $est) {

            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="editarEstudiante(' . $est->id . ')">
                                <i class="fa fa-pencil-square fa-lg"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarEstudiante(' . $est->id . ')">
                                <i class="fa fa-trash fa-lg"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $est->persona->cedula,
                2 => $est->persona->nombres,
                3 => $est->persona->apellidos,
                4 => $est->persona->celular,
                5 => $est->persona->direccion,
                6 => $est->persona->sexo->sexo,
                7 => $est->curso->nombre_curso,
                8 => $est->paralelo->tipo,
                9 => $botones,
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

    public function editar(Request $request)
    {
        $this->cors->corsJson();
        $estRequest = $request->input('estudiante');

        $id = intval($estRequest->id);
        $persona_id = intval($estRequest->persona_id);
        $curso_id = intval($estRequest->curso_id);
        $paralelo_id = intval($estRequest->paralelo_id);

        $response = [];
        $est = Estudiante::find($id);
        if ($estRequest) {
            if ($est) {
                $est->persona_id = $persona_id;
                $est->curso_id = $curso_id;
                $est->paralelo_id = $paralelo_id;

                $persona = Persona::find($est->persona_id);
                $persona->sexo_id = intval($estRequest->sexo_id);
                $persona->nombres = ucfirst($estRequest->nombres);
                $persona->apellidos = ucfirst($estRequest->apellidos);
                $persona->celular = $estRequest->celular;
                $persona->direccion = ucfirst($estRequest->direccion);
                $persona->save();
                $est->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'El Estudiante se ha actualizado',
                    'estudiante' => $est,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el Estudiante',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos...!!'
            ];
        }
        echo json_encode($response);
    }

    public function eliminar(Request $request)
    {
        $this->cors->corsJson();
        $estudianteRequest = $request->input('estudiante');
        $id = intval($estudianteRequest->id);

        $est = Estudiante::find($id);
        $response = [];

        if ($est) {
            $est->estado = 'I';

            $persona = Persona::find($est->persona_id);
            $persona->estado = 'I';
            $persona->save();
            $est->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el Estudiante',
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se ha podido eliminar el Estudiante',
            ];
        }
        echo json_encode($response);
    }

    public function verdocentestudiantes($params)
    {
        $this->cors->corsJson();
        $curso_id = intval($params['curso_id']);
        $paralelo_id = intval($params['paralelo_id']);
        $estudiante = Estudiante::where('curso_id', $curso_id)->where('paralelo_id', $paralelo_id)->where('estado', 'A')->get();
        $data = [];
        $i = 1;

        foreach ($estudiante as $est) {
            $us = Usuario::find($est->persona_id);
            $url = BASE . 'resources/usuarios/' . $us->img;
            $botones = '<div>
                    <button class="btn btn-primary btn-sm" onclick="calificarEstudiante(' . $est->id . ')">
                        <i class="fa fa-pencil-square fa-lg"></i>Calificar
                    </button>
                    <button class="btn btn-primary btn-sm" onclick="calificarEstudianteExamen(' . $est->id . ')">
                        <i class="fa fa-pencil-square fa-lg"></i>Exámen
                    </button>
                </div>';

            $data[] = [
                0 => $i,
                1 => '<div class="box-img-usuario"><img src=' . "$url" . '></div>',
                2 => $est->persona->cedula,
                3 => $est->persona->nombres.' '.$est->persona->apellidos,
                4 => $est->persona->celular,
                5 => $est->persona->direccion,
                6 => $botones,
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

    public function estudianteCalificar($params){
        $this->cors->corsJson();
        $estudiante_id = intval($params['estudiante_id']);
        $curso_id = intval($params['curso_id']);
        $paralelo_id = intval($params['paralelo_id']);
        $estudiante = Estudiante::where('id', $estudiante_id)->where('curso_id', $curso_id)->where('paralelo_id', $paralelo_id)->where('estado', 'A')->get();

        if (count($estudiante) > 0) {
            foreach ($estudiante as $est) {
                $est->persona;
                $est->curso;
                $est->paralelo;
            }
            $response = [
                'status' => true,
                'estudiante' => $estudiante,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el estudiante',
                'estudiante' => null,
            ];
        }
        echo json_encode($response);
        
    }

    public function dataTableEstudianteReporte()
    {
        $this->cors->corsJson();

        $estudiantes = Estudiante::where('estado', 'A')->orderBy('id','desc')->get();
     
        $data = [];    $i = 1;

        foreach ($estudiantes as $est) {
            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="seleccionarEstudiante(' . $est->id . ')">
                                <i class="fa fa-check fa-lg"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $est->persona->nombres .' '. $est->persona->apellidos,
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
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
        $this->db = new Conexion();
    }

    public function listarId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $estudiante = Estudiante::find($id);
        $response = [];

        if ($estudiante) {
            $estudiante->persona;
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
                4 => $est->curso->nombre_curso,
                5 => $est->paralelo->tipo,
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

    public function editar(Request $request)
    {

        $this->cors->corsJson();
        $usuRequest = $request->input('usuario');

        $id = intval($usuRequest->id);
        $persona_id = intval($usuRequest->persona_id);
        $rol_id = intval($usuRequest->rol_id);
        $usuario = ucfirst($usuRequest->usuario);

        $response = [];
        $usu = Usuario::find($id);
        if ($usuRequest) {
            if ($usu) {
                $usu->persona_id = $persona_id;
                $usu->rol_id = $rol_id;
                $usu->usuario = $usuario;

                $persona = Persona::find($usu->persona_id);
                $persona->nombres = ucfirst($usuRequest->nombres);
                $persona->apellidos = ucfirst($usuRequest->apellidos);
                $persona->save();
                $usu->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'El Usuario se ha actualizado',
                    'data' => $usu,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el usuario',
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
        $usuarioRequest = $request->input('usuario');
        $id = intval($usuarioRequest->id);

        $usuario = Usuario::find($id);
        $response = [];

        if ($usuario) {
            $usuario->estado = 'I';
            $usuario->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el usuario',
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se ha podido eliminar el usuario',
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
            $botones = '<div class="btn-group">
                    <button class="btn btn-primary btn-sm" onclick="calificarEstudiante(' . $est->id . ')">
                        <i class="fa fa-pencil-square fa-lg"></i>
                    </button>
                </div>';

            $data[] = [
                0 => $i,
                1 => $est->persona->cedula,
                2 => $est->persona->nombres,
                3 => $est->persona->apellidos,
                4 => $est->curso->nombre_curso,
                5 => $est->paralelo->tipo,
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

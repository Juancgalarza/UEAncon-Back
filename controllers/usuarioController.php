<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/usuarioModel.php';
require_once 'models/personaModel.php';
require_once 'controllers/personaController.php';
require_once 'controllers/rolController.php';
require_once 'models/sexoModel.php';
require_once 'models/cursoModel.php';

class UsuarioController
{
    private $cors;
    private $personaController;
    private $rolCtr;


    public function __construct()
    {
        $this->cors = new Cors();
        $this->db = new Conexion();
        $this->personaController = new PersonaController();
        $this->rolCtr = new Rol();
    }

    public function login2(Request $request)
    {
        $data = $request->input('login');
        $entrada = $data->entrada;
        $clave = $data->clave;
        $encriptar = hash('sha256', $clave);

        $this->cors->corsJson();
        $response = [];

        $captcha = $data->captcha;
        $secret = "6LcwucIhAAAAALT0HeQPn8pGvtJ6znU8ccS3g94F";
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $responseCaptcha = file_get_contents($url . "?secret=" . $secret . "&response=" . $captcha);
        $atributosCaptcha = json_decode($responseCaptcha);

        if (!$atributosCaptcha->success) {
            $response = [
                'status' => false,
                'mensaje' => 'El Captcha es Inválido',
            ];
        } else {
            if ((!isset($entrada) || $entrada == "") || (!isset($clave) || $clave == "")) {
                $response = [
                    'estatus' => false,
                    'mensaje' => 'Falta datos',
                ];
            } else {
                $usuario = Usuario::where('usuario', $entrada)->orWhere('correo', $entrada)->get()->first();

                if ($usuario) { //x usuario
                    if ($this->checkValidator($encriptar, $usuario->clave)) {
                        $usuario->persona;
                        $rol = $usuario->rol;

                        $per = Persona::find($usuario->persona_id);

                        $usuario['persona'] = $per;
                        $nombre = $per->nombres . ' ' . $per->apellidos;

                        //estudiante id
                        $estudiante = $usuario->persona->estudiante;
                        $est_id = [];
                        foreach ($estudiante as $est) {
                            $est_id = $est->id;
                        }

                        //docente id
                        $docente = $usuario->persona->docente;
                        $docen_id = [];
                        foreach ($docente as $doc) {
                            $docen_id = $doc->id;
                        }

                        $response = [
                            'status' => true,
                            'mensaje' => 'Acceso al sistema',
                            'rol' => $rol,
                            'persona' => $nombre,
                            'usuario' => $usuario,
                            'estudiante' => $est_id,
                            'docente' => $docen_id
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'mensaje' => 'credenciales incorrecta'
                        ];
                    }
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El usuario no se encuentra en la Base de Datos'
                    ];
                }
            }
        }
        echo json_encode($response);
    }

    public function buscar($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $usuario = Usuario::find($id);
        $response = [];

        if ($usuario) {
            $usuario->persona->sexo;

            $response = [
                'status' => true,
                'usuario' => $usuario,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el usuario',
                'usuario' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $user = $request->input('usuario');
        $est = $request->input('estudiante');
        $response = [];

        $curso_id = intval($est->curso_id);
        $paralelo_id = intval($est->paralelo_id);

        if (!isset($user) || $user == null) {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'usuario' => null,
            ];
        } else {
            $resPersona = $this->personaController->guardarPersona($request);

            $id_pers = $resPersona['persona']->id;

            $clave = $user->clave;
            $encriptar = hash('sha256', $clave);
            $user->rol_id = intval($user->rol_id);

            $usuario = new Usuario;
            $usuario->persona_id = $id_pers;
            $usuario->rol_id = $user->rol_id;
            $usuario->usuario = $user->usuario;
            $usuario->correo = $user->correo;
            $usuario->img = $user->img;
            $usuario->clave = $encriptar;
            $usuario->conf_clave = $encriptar;
            $usuario->estado = 'A';

            //buscar en usuarios el id_persona si existe y validar
            $exis_user = Usuario::where('persona_id', $id_pers)->get()->first();

            if ($exis_user) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El usuario ya se encuentra registrado',
                    'usuario' => null,
                ];
            } else {
                if ($usuario->save()) {
                    //verificar si ahi un rol est
                    if ($usuario->rol_id == 2) {
                        //Crear un est y guardar
                        $estudiante = new Estudiante;
                        $estudiante->persona_id = $id_pers;
                        $estudiante->curso_id = $curso_id;
                        $estudiante->paralelo_id = $paralelo_id;
                        $estudiante->estado = 'A';
                        $estudiante->save();
                    } else if ($usuario->rol_id == 3) {

                        $docente = new Docente;
                        $docente->persona_id = $id_pers;
                        $docente->estado = 'A';
                        $docente->save();
                    }
                    $response = [
                        'status' => true,
                        'mensaje' => 'Se ha guardado el usuario',
                        'usuario' => $usuario,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo guardar el usuario',
                        'usuario' => null,
                    ];
                }
            }
        }

        echo json_encode($response);
    }

    public function subirFichero($file)
    {
        $this->cors->corsJson();
        $img = $file['fichero'];
        $path = 'resources/usuarios/';

        $response = Helper::save_file($img, $path);
        echo json_encode($response);
    }

    private function checkValidator($credencia1, $credencial2)
    {
        if ($credencia1 == $credencial2) {
            return true;
        } else {
            return false;
        }
    }

    public function dataTable()
    {
        $this->cors->corsJson();

        $usuarios = Usuario::where('rol_id','<>',2)->where('estado', 'A')->orderBy('id', 'desc')->get();
        $data = [];
        $i = 1;

        foreach ($usuarios as $u) {
            $url = BASE . 'resources/usuarios/' . $u->img;
            //$estado = $u->estado == 'A' '<span class="badge bg-success">Activado</span>'?
            $icono = $u->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $u->estado == 'I' ? 'btn-success btn-sm' : 'btn-danger btn-sm';
            $other = $u->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="editar_usuario(' . $u->id . ')">
                                <i class="fa fa-pencil-square fa-lg"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminar(' . $u->id . ',' . $other . ')">
                                ' . $icono . '
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => '<div class="box-img-usuario"><img src=' . "$url" . '></div>',
                2 => $u->persona->nombres,
                3 => $u->persona->apellidos,
                4 => $u->persona->celular,
                5 => $u->persona->direccion     ,
                6 => $u->usuario,
                7 => $u->correo,
                8 => $u->rol->cargo,
                9 => $u->persona->sexo->sexo,
                10 => $botones,
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

    public function contar()
    {
        $this->cors->corsJson();
        $usuarios = Usuario::where('estado', 'A')->get();
        $response = [];
        if ($usuarios) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen Usuario',
                'Modelo' => 'Usuario',
                'cantidad' => $usuarios->count()
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No Existen Usuario',
                'Modelo' => 'Usuario',
                'cantidad' => 0
            ];
        }
        echo json_encode($response);
    }

    public function editar(Request $request)
    {

        $this->cors->corsJson();
        $usuRequest = $request->input('usuario');

        $id = intval($usuRequest->id);
        $persona_id = intval($usuRequest->persona_id);
        $usuario = ucfirst($usuRequest->usuario);
        $correo = $usuRequest->correo;

        $response = [];
        $usu = Usuario::find($id);
        if ($usuRequest) {
            if ($usu) {
                $usu->persona_id = $persona_id;
                $usu->usuario = $usuario;
                $usu->correo = $correo;

                $persona = Persona::find($usu->persona_id);
                $persona->sexo_id = intval($usuRequest->sexo_id);
                $persona->nombres = ucfirst($usuRequest->nombres);
                $persona->apellidos = ucfirst($usuRequest->apellidos);
                $persona->celular = $usuRequest->celular;
                $persona->direccion = ucfirst($usuRequest->direccion);
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

    public function listUsers()
    {

        $users = Usuario::where('rol_id', '<>', 4)->where('estado', 'A')->get();
        $resp = [];

        if ($users->count() > 0) {
            $resp = $users;
            foreach ($resp as $item) {
                $item->persona;
                $item->rol;
            }
        }

        echo json_encode($resp);
    }

    public function guardarEstudiante(Request $request)
    {
        $this->cors->corsJson();
        $users = $request->input('usuario');
        $est = $request->input('estudiante');
        $response = [];

        $curso_id = intval($est->curso_id);
        $paralelo_id = intval($est->paralelo_id);

        if (!isset($users) || $users == null) {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'usuario' => null,
            ];
        } else {
            $curso_dis = Curso::find($curso_id);
            if ($curso_dis->capacidad == $curso_dis->total_estudiantes) {
                $response = [
                    'status' => false,
                    'mensaje' => 'No hay cupos disponibles para el curso',
                    'estudiante' => null,
                ];
            } else {
                $curso_dis->total_estudiantes += 1;
                $curso_dis->save();
                $resPersona = $this->personaController->guardarPersona($request);
    
                $id_pers = $resPersona['persona']->id;
    
                $clave = $users->clave;
                $encriptar = hash('sha256', $clave);
    
                $usuario = new Usuario;
                $usuario->persona_id = $id_pers;
                $usuario->rol_id = 2;
                $usuario->usuario = $users->usuario;
                $usuario->correo = $users->correo;
                $usuario->img = $users->img;
                $usuario->clave = $encriptar;
                $usuario->conf_clave = $encriptar;
                $usuario->estado = 'A';
    
                //buscar en usuarios el id_persona si existe y validar
                $exis_user = Usuario::where('persona_id', $id_pers)->get()->first();
    
                if ($exis_user) {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El estudiante ya se encuentra registrado',
                        'estudiante' => null,
                    ];
                } else {
                    if ($usuario->save()) {  
                        //Crear un est y guardar
                        $estudiante = new Estudiante;
                        $estudiante->persona_id = $id_pers;
                        $estudiante->curso_id = $curso_id;
                        $estudiante->paralelo_id = $paralelo_id;
                        $estudiante->estado = 'A';
                        $estudiante->save();
                        
                        $response = [
                            'status' => true,
                            'mensaje' => 'Se ha guardado el estudiante',
                            'usuario' => $usuario,
                            'estudiante' => $estudiante,
                            'curso' => $curso_dis,
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'mensaje' => 'No se pudo guardar el estudiante',
                            'estudiante' => null,
                        ];
                    }
                }
            }
        }

        echo json_encode($response);
    }

    public function subirFicheroEstudiante($file)
    {
        $this->cors->corsJson();
        $img = $file['fichero'];
        $path = 'resources/usuarios/';

        $response = Helper::save_file($img, $path);
        echo json_encode($response);
    }
}

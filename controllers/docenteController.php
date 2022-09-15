<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/docenteModel.php';
require_once 'models/personaModel.php';

class DocenteController
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
        $docente = Docente::find($id);
        $response = [];

        if ($docente) {
            $docente->persona;
            $response = [
                'status' => true,
                'docente' => $docente,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el docente',
                'docente' => null,
            ];
            
        }
        echo json_encode($response);
    }

 
    public function dataTable()
    {
        $this->cors->corsJson();

       $docente = Docente::where('estado', 'A')->orderBy('id','desc')->get();

        $data = [];    $i = 1;

        foreach ($docente as $u) {
           
            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="seleccionarDocente(' . $u->id . ')">
                                <i class="fa fa-check fa-lg"></i>
                            </button>
                       
                        </div>';

            $data[] = [
                0 => $i,
                1 => $u->persona->nombres .' '. $u->persona->apellidos,
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


    //post
 /*    public function editar(Request $request){
        
        $this->cors->corsJson();   
        $usuRequest = $request->input('usuario');

        $id = intval($usuRequest->id);
        $persona_id = intval($usuRequest->persona_id);
        $rol_id = intval($usuRequest->rol_id);
        $usuario = ucfirst($usuRequest->usuario);

        $response = [];       
        $usu = Usuario::find($id);
        if($usuRequest){
            if($usu){
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
            }else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el usuario',
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos...!!'
            ];
        }
        echo json_encode($response);
    }

    public function eliminar(Request $request){
        $this->cors->corsJson();
        $usuarioRequest = $request->input('usuario');
        $id = intval($usuarioRequest->id);

        $usuario = Usuario::find($id);
        $response = [];

        if($usuario){
            $usuario->estado = 'I';
            $usuario->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el usuario', 
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No se ha podido eliminar el usuario', 
            ];
        }
        echo json_encode($response);
    }
    
    public function listUsers(){

        $users = Usuario::where('rol_id', '<>', 4)->where('estado', 'A')->get();
        $resp = [];

        if($users->count() > 0){
            $resp = $users;
            foreach($resp as $item){
                $item->persona;
                $item->rol;
            }
        } 
        
        echo json_encode($resp);
    } */

}
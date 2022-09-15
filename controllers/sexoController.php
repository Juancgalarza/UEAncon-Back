<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/sexoModel.php';

class SexoController
{
    private $cors;
  
    public function __construct()
    {
        $this->cors = new Cors();
       
    }

    public function listar()
    {
        $this->cors->corsJson();

        $sexos = Sexo::where('estado', 'A')->get();
        $response = [];

        if (count($sexos) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen sexos',
                'sexo' => $sexos,
            ];
        } else {
            $response = [
                'status' => false,
                'sexo' => null,
                'mensaje' => 'No existen sexos',
            ];
        }
        echo json_encode($response);
    }
}

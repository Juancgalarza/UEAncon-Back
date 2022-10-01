<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/jornadaModel.php';

class JornadaController
{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();
       
    }

    public function listar()
    {
        $this->cors->corsJson();
        $jornadas = Jornada::where('estado', 'A')->orderBy('jornada')->get();
        $response = [];

        if ($jornadas) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'jornada' => $jornadas,
            ];
        } else {
            $response = [
                'status' => false,
                'jornada' => null,
                'mensaje' => 'No existen datos',
            ];
        }
        echo json_encode($response);
    }
}

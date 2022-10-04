<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/quimestreModel.php';

class QuimestreController
{
    private $cors;
  
    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listar()
    {
        $this->cors->corsJson();

        $quimestres = Quimestre::where('estado', 'A')->orderBy('quimestre')->get();
        $response = [];

        if ($quimestres) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen quimestres',
                'quimestre' => $quimestres,
            ];
        } else {
            $response = [
                'status' => false,
                'quimestre' => null,
                'mensaje' => 'No existen quimestres',
            ];
        }
        echo json_encode($response);
    }
}

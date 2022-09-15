<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
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

        $quimestres = Quimestre::where('estado', 'A')->get();
        $response = [];

        if (count($quimestres) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen quimestres',
                'quimestre' => $quimestres,
            ];
        } else {
            $response = [
                'status' => false,
                'parcial' => null,
                'quimestre' => 'No existen quimestres',
            ];
        }
        echo json_encode($response);
    }

    public function listarId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $quimestre = Quimestre::find($id);
        $response = [];

        if ($quimestre) {
            $response = [
                'status' => true,
                'quimestre' => $quimestre,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el quimestre',
                'quimestre' => null,
            ];
            
        }
        echo json_encode($response);
    }
}

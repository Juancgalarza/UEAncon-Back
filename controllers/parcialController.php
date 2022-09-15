<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/parcialModel.php';

class ParcialController
{
    private $cors;
  
    public function __construct()
    {
        $this->cors = new Cors();
       
    }

    public function listar()
    {
        $this->cors->corsJson();

        $parciales = Parcial::where('estado', 'A')->get();
        $response = [];

        if (count($parciales) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen parciales',
                'parcial' => $parciales,
            ];
        } else {
            $response = [
                'status' => false,
                'parcial' => null,
                'mensaje' => 'No existen parciales',
            ];
        }
        echo json_encode($response);
    }

    public function listarId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $parcial = Parcial::find($id);
        $response = [];

        if ($parcial) {
            $response = [
                'status' => true,
                'parcial' => $parcial,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el parcial',
                'parcial' => null,
            ];
            
        }
        echo json_encode($response);
    }
}

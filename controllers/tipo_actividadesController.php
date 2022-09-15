<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/tipo_actividadesModel.php';

class Tipo_ActividadesController
{

    private $cors;
  
    public function __construct()
    {
        $this->cors = new Cors();
       
    }

    public function listar()
    {
        $this->cors->corsJson();

        $tipoactividades = Tipo_Actividades::where('estado', 'A')->orderBy('id')->get();
        $response = [];

        if ($tipoactividades) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen tipos',
                'tipo' => $tipoactividades,
            ];
        } else {
            $response = [
                'status' => false,
                'tipo' => null,
                'mensaje' => 'No existen tipos',
            ];
        }
        echo json_encode($response);
    }
}

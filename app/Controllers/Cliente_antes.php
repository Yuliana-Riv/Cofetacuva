<?php

namespace App\Controllers;

use App\Models\ClienteModel;

Class Cliente extends BaseController{

    
    public function index(){

        $clienteModel =  new ClienteModel();

       // $resultado = $clienteModel->find(1);
       //$resultado = $clienteModel->findAll();
        
       $data = [ 
        "nombre" => "alex",
        "apellidos" => "Gonzalez",
        "telefono" => "622 146",
        "correo" => "alex@gmail.com",
        "contrasena" => "12323edsad",
        "entrenador_id" => 1,
        "gimnasio_id" => 1,
        "dia_pago" =>1,
        "fecha_inicio" => date("Y-m-d"),
        "estado" => "activo"
       ];

      $clienteId = $clienteModel->insert($data);
      $resultado = $clienteModel->find($clienteId);

       
       echo json_encode($resultado);


    }

}
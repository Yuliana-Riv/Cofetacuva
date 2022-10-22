<?php
namespace App\Controllers;

header('Access-Control-Allow-Origin: *');

use CodeIgniter\RESTful\ResourceController;
use App\models\administradorModel;
use App\models\clienteModel;
use Firebase\JWT\JWT;
Use Firebase\JWT\Key;

use Config\Services;



Class Auth extends ResourceController{

    protected $format  = 'json';

    protected $token;

    protected $administrador;

    protected $cliente;

    protected $tipoUsuario;

    public function __construct(){

    }


    public function create(){

      $user = $this->request->getPost("user");
      $password = $this->request->getPost("password");
      $tipo = $this->request->getPost("tipo");

      if($tipo=="administrador"){
        $administradorModel = new administradorModel();
        $this->administrador =  $administradorModel->login($user, $password);

        if($this->administrador){
          $now = time();
          $key =   Services::getSecretKey();
          $user_id = $this->administrador["id"];

          $payload = [
            'aud' => "C:\laragon\www\cafeteria\pages",
            'iat' => $now, // cuando se creo
            'nbf' => $now, // cuando se empezara a utilizar,
            //'exp' => $now+(60*60*24*7),
            'exp' => $now+(60*60*24*1),
            'data' =>[
                      "user_id" =>  $user_id, 
                      "tipo" =>  $tipo, 
                     ]
          ];

          $jwt = JWT::encode( $payload,$key,"HS256");
        return $this->respond(["token" => $jwt, "user" => $this->administrador, "tipo" =>$tipo]);

        }else{
          return $this->respond(["error" => "usuario o contraseña incorrectos!"],400);
        }
      }

      if($tipo=="cliente"){
          $clienteModel = new clienteModel();
          $this->cliente = $clienteModel->login($user, $password);
          /////////////
          if($this->cliente){
            $now = time();
            $key =   Services::getSecretKey();
            $user_id = $this->cliente["id"];
  
            $payload = [
              'aud' => "C:\laragon\www\cafeteria\pages",
              'iat' => $now, // cuando se creo
              'nbf' => $now, // cuando se empezara a utilizar, 
              'exp' => $now+(60*60*24*1),
              'data' =>[
                        "user_id" =>  $user_id, 
                        "tipo" =>  $tipo, 
                       ]
            ];
  
          $jwt = JWT::encode( $payload,$key,"HS256");
          return $this->respond(["token" => $jwt, "user" => $this->cliente, "tipo" =>$tipo]);
  
          }else{
            return $this->respond(["error" => "usuario o contraseña incorrectos!"]);
          }
          ///////////////////

      }



    }




    public function verifyToken(){
      $key =   Services::getSecretKey(); 
      $token_str = $this->request->getHeader("token")->getValue();
      
      try {
        $token = JWT::decode($token_str, new key ($key,'HS256') );
      } catch (\Throwable $th) {
        $token = false;
      }    

      if(!$token){
           return false;
      }else{

        if($token->data->tipo == "administrador"){
          $administradorModel = new administradorModel();
          $this->administrador =   $administradorModel->find($token->data->user_id);
          $this->tipoUsuario ="administrador";

        }else{
          $clienteModel = new ClienteModel();
          $this->cliente =  $clienteModel->find($token->data->user_id);
          $this->tipoUsuario ="cliente";
        }
        return true;     

      }

    }





    public function validarAdministrador(){
    
      $user =$this->request->getHeader("user")->getValue();
      $password = $this->request->getHeader("password")->getValue();
      $userModel = new  administradorModel();
      $user = $userModel->login($user,  $password);

      return $user;
    }




}

 

 



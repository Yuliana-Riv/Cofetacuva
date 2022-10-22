<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\models\AdministradorModel;

Class Producto extends Auth{

    protected $modelName = 'App\Models\productoModel';
    protected $format  = 'json';

    public function index(){
     
/*       $user= $this->validarAdministrador();     
      if(!$user){  return  $this->respond(
        ["error" => "usuario o contraseña incorrectos;"]
      ); } */

     if(!$this->verifyToken()){
       return $this->respond(["error" => "Token expirado!"]);
     }   

      
      $data=[
            "productos" => $this->model->findAll(),
            "administrador" => $this->administrador
        ];         

        return $this->respond($data);
    }

    public function show($id = NULL){

      if(!$this->verifyToken() ){
        return $this->respond(["error" => "Token expirado!"]);
      }  

      if( $this->tipoUsuario == "administrador" || $this->producto["id"] == $id ){
       
      }else{
        return $this->respond(["error" => "No tienes permisos para ver esta informacion!"]);
      }

        $data=[
            "producto" => $this->model->find($id)
        ];

        return $this->respond($data);
    }


    public function create(){

      if(!$this->verifyToken()){  return $this->respond(["error" => "Token expirado!"]);      }   
 


  //    $_POST["asdasd"];/ $this->request->getPost('asdasd')
        $data =[
            "nombre" => $this->request->getPost('nombre'),
            "descripcion" => $this->request->getPost('descripcion'),
            "precio" => $this->request->getPost('precio')
        ];

        $id = $this->model->insert($data);

        if($id){
            return $this->respond($this->model->find($id));
        }else{
            return $this->respond(["error" => "El producto no se agregó correctamente!"]);
        } 

    }


    public function update($id=null){

      if(!$this->verifyToken()){  return $this->respond(["error" => "Token expirado!"]);      }   

              $data= [];

              if(!empty($this->request->getPost('nombre'))){
                $data["nombre"] = $this->request->getPost('nombre');
              }
              if(!empty($this->request->getPost('descripcion')))
                $data["descripcion"] = $this->request->getPost('descripcion');

              if(!empty($this->request->getPost('precio')))
                $data["precio"] = $this->request->getPost('precio');

          


      
              $result = $this->model->update($id,$data);
      
              if($result){
                  $producto = $this->model->find($id);
                  return $this->respond(["result" => "El producto de editó correctamente!", "data"=>$producto]);
              }else{
                  return $this->respond(["error" => "El producto NO se editó correctamente!"]);
              } 
      
          }


         /* public function delete($id=null){
            if(!$this->verifyToken()){  return $this->respond(["error" => "Token expirado!"]);      }   

             $result= $this->model->delete($id);

             if($result){ 
                return $this->respond(["result" => "El producto se eliminó correctamente!"]);
            }else{
                return $this->respond(["error" => "No se eliminó correctamente!"]);
            } 

          }*/


}

<?php 
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\MenuModel;


class Menu extends ResourceController{
    protected $modelName = 'App\Models\MenuModel';
    protected $format = 'json';
    
    public function index(){
        $data=[
            "menus" => $this->model->findAll()
        ];
        return $this->respond($data);
    }

    public function show($id = null)
    {
        $data=[
            "menu" => $this->model->find($id)
        ];
        return $this->respond($data);
    }

    public function create(){
        $data =[
            "id" => $this->request->getPost("id"),
            "titulo" => $this->request->getPost("titulo"),
            "estado" => $this->request->getPost("estado"),
        ];

        $id = $this->model->insert($data);
        if($id){
            return $this->respond($this->model->find($id));
        }else{
            return $this->respond(["error" => "hubo un error al insertar"]);
        }
    }

    public function update($id = null)
    {
        $data = [];
        if(!empty($this->request->getPost("titulo")))
            $data["titulo"] = $this->request->getPost("titulo");
        if(!empty($this->request->getPost("estado")))
            $data["estado"] = $this->request->getPost("estado");
        
        $result = $this->model->update($id, $data);

        if($result){
            return $this->respond(["result" => "El registro se edito correctamente"]);
        }else{
            return $this->respond(["error" => "hubo un error al editar"]);
        }
    }

    public function delete($id = null)
    {
        $result = $this->model->delete($id);
        if($result){
            return $this->respond(["result"=> "El registro se eliminó correctamente"]);
        }else{
            return $this->respond((["error" => "Hubo un error al eliminar"]));
        }
    }
}

?>
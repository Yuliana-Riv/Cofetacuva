<?php

namespace app\Models;

use CodeIgniter\Model;

class AdministradorModel extends Model{

    protected $table= "administradores";
    protected $primarykey= "id";

  
    protected $allowedFields = [
        "id",
        "cuenta",      
        "contrasena"
    ];


    public function login($user, $password){
        
        $result = $this->asArray()
        ->where([
            "cuenta" => $user,
            "contrasena" => $password
        ])->first();

        return $result;

    }

 
   
  
}
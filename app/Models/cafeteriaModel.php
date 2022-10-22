<?php

namespace app\Models;

use CodeIgniter\Model;

class CafeteriaModel extends Model{
    
    protected $table= "cafeterias";
    protected $primarykey= "id";

    protected $allowefields= [
        "id",
        "nombre",
        "direccion",
        "telefono",
        "correo",
        "horarios"
    ];
    
}
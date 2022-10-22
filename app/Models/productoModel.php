<?php

namespace app\Models;

use CodeIgniter\Model;

class ProductoModel extends Model{

    protected $table= "productos";
    protected $primarykey= "id";

    protected $allowedfields=[
        "id",
        "nombre",
        "descripcion",
        "precio",
        "categoria" 
    ];
}
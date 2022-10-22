<?php

namespace app\Models;

use CodeIgniter\Model;

class PagoClienteModel extends Model{

    protected $table="pagos_clientes";
    protected $primarykey= "id";

    protected $allowedfields=[
        "id",
        "cliente_id",
        "cobro"
    ];
}
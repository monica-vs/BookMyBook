<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model {

    use HasFactory;

    protected $table = 'pedidos_detalle';
    public $timestamps = false;
    protected $primaryKey = 'libro_id';

}

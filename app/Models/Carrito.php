<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Carrito extends Model
{
    use HasFactory;
    
    protected $table = 'carrito';
    public $timestamps = false;
    protected $primaryKey = ['usuario_id', 'libro_id'];
}

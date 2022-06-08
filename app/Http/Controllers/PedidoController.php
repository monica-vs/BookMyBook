<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::all();
        return response()->json($pedidos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = request()->all();
        Pedido::insert($datos);
        $ultimopedido = Pedido::orderBy('id', 'desc')->first();
        return response()->json($ultimopedido);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::find($id);
        return response()->json($pedido);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datos = request()->except("_token");
        $pedido = Pedido::find($id);
        
        //Timestamps debe actualizarse a false para poder realizar la actualización sin errores
        $pedido->timestamps = false;
        
        //Actualización del número de envío
        if(array_key_exists('num_envio',$datos)){
            $pedido->num_envio = $datos['num_envio'];
            $pedido->enviado = 1;
            $pedido->save();
        }
        
        //Actualización del estado del pedido, que pasará a mostrarse como recibido
        if(array_key_exists('recibido',$datos)){
            $pedido->recibido = 1;
            $pedido->save();
        }
        return response()->json($pedido);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

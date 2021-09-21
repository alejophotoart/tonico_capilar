<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductWarehouse;
use Illuminate\Http\Request;

class ProductWarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_warehouses = ProductWarehouse::where('active', 1)->orderBy('id', 'asc')->with(['warehouses', 'products'])->get();
        // dd($product_warehouses);
        return view ('admin.product_warehouses.index')->with('product_warehouses', $product_warehouses);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return ProductWarehouse::where('id', $id)->with('warehouses', 'products')->first();
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
        // dd($request->all());

        if($request){
            $product = Product::where('id', $request['product_id_pw'])->first();
            $product_warehouse = ProductWarehouse::where('product_id', $request['product_id_pw'])->where('warehouse_id', $request['warehouse_id_pw'])->first();
            if( $product->quantity >= intval($request['quantity'])){
                $product->quantity = $product->quantity - intval($request['quantity']);
                $product->update();
                $product_warehouse->quantity = $product_warehouse->quantity + intval($request['quantity']);
                $product_warehouse->update();
                return response(array('status' => 200, 'd' => array('id' => $id),'title' => 'Cantidad actualizada' ,'message' => 'Actualizaste la cantidad del producto en la bodega', 'space' => ' ','name' => $request->name, 'icon' => "success"));
            }else{
                return response(array('status' => 400, 'title' => __('Unidades Insuficientes') ,'message' => __('Las unidades asignadas a esta bodega superan las unidades disponibles del producto'), 'icon' => "error"));
            }
        } else {
            return response(array('status' => 100, 'title' => __('Ops...') ,'message' => __('Ocurrio un error inesperado, intentalo de mas tarde'), 'icon' => "warning"));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $name, $name2, $product_id)
    {
        $product_warehouse = ProductWarehouse::where('id', $id)->first();

        $product = Product::where('id', $product_id)->first();
        $product->quantity = $product->quantity + $product_warehouse->quantity;
        $product->update();

        $product_warehouse->delete();

        return array('status' => 200, 'title' => 'Producto eliminado' ,'message' => 'Elimiaste el producto', 'space' => ' ' ,'name' => $name, 'space' => ' ','message2' => 'de la bodega', 'space' => ' ','name2' => $name2,'icon' => "success");
    }
}

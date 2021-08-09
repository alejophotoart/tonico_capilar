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
        return ProductWarehouse::where('id', $id)->with('warehouses')->first();
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
            $product_warehouse = ProductWarehouse::where('id', $id)->update([
                'quantity'  => $request['quantity']
            ]);
            // $quantityProduct = Product::where('id', $request['product_id_pw'])->first();
            // dd($quantityProduct->quantity);
            // $resul = (($quantityProduct->quantity) - floatval($request['quantity']));
            // $toDiscountProduct = Product::where('id', $request['product_id_pw'])->update([
            //     'quantity'  => (($quantityProduct->quantity) - ($resul))
            // ]);
            // dd($toDiscountProduct);
            return response(array('status' => 200, 'd' => array('id' => $id),'title' => 'Cantidad actualizada' ,'message' => 'Actualizaste la cantidad del producto en la bodega', 'space' => ' ','name' => $request->name, 'icon' => "success"));
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
    public function destroy($id, $name, $name2)
    {
        $product_warehouse = ProductWarehouse::where('id', $id)->first();
        $product_warehouse->delete();

        return array('status' => 200, 'title' => 'Item eliminado' ,'message' => 'Elimiaste el producto', 'space' => ' ' ,'name' => $name, 'space' => ' ','message2' => 'de la bodega', 'space' => ' ','name2' => $name2,'icon' => "success");
    }
}

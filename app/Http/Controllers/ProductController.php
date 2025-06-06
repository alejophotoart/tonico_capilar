<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductWarehouse;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Laravel\Ui\Presets\React;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products  = Product::where('active', 1 )->orderBy('id')->with('product_warehouses')->get();
        $product_warehouses = ProductWarehouse::where('active', 1)->with('warehouses')->get();
        // dd($products);
        return view('admin.products.index')
        ->with('products', $products)
        ->with('product_warehouses', $product_warehouses);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.products.create', [
            'product' => new Product,
            'warehouses' => Warehouse::where([['active', 1],['state_warehouse_id', 1]])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if($request['description'] > 400){
            return response(array('status' => 500, 'title' => 'Descripcion del productooo' ,'message' => __('la descripcion es muy larga, intenta con algo mas corto'), 'icon' => "error"));
                }else{
                if(Product::where('code', $request["code"])->first()){
                    return response(array('status' => 400, 'title' => 'Codigo del producto' ,'message' => __('Ya existe un producto con ese codigo'), 'icon' => "error"));
                }else{
                if (isset($request)) {
                        $product = Product::create([
                            'code'          => $request['code'],
                            'name'          => $request['name'],
                            'price'         => $request['price'],
                            'quantity'      => $request['quantity'],
                            'description'   => $request['description']
                        ]);
                        $prodcut_warehouses = count($request['warehouses']);
                        for($i = 0; $i < $prodcut_warehouses; $i++){
                            $prod_ware                  = new ProductWarehouse;
                            $prod_ware->quantity        = $request['quantity']; //posicion de las cantidades
                            $prod_ware->product_id      = $product['id']; //posicion de los id del producto
                            $prod_ware->warehouse_id    = $request['warehouses'][$i];
                            $prod_ware->save();
                        }

                        return response(array('status' => 200, 'd' => array('code' => $request->code),'title' => 'Producto creado' ,'message' => 'Creaste el producto', 'space' => ' ','name' => $request->name, 'icon' => "success"));
                } else {
                    return response(array('status' => 100, 'title' => __('Ops...') ,'message' => __('Ocurrio un error inesperado, intentalo de mas tarde'), 'icon' => "warning"));
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveImage(Request $request)
    {
        $code = $request->code;
        $num_ram = rand(1, 999);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filenamestore = $num_ram . time() . '.' . $extension;


        Storage::disk('public')->put(env('') . $filenamestore, fopen($request->file('image'), 'r+'), 'public');

        $status = Product::where('code', $code)->update(['img' => $filenamestore, 'link' => 'adminlte/img/products/']);
        if ($status) {
            return response(array('status' => 200, 'title' => 'Producto creado' ,'message' => 'Creaste el producto', 'space' => ' ','name' => $request->name, 'icon' => "success"));
        } else {
            return response(array('status' => 100, 'title' => __('Ops...') ,'message' => __('Ocurrio un error inesperado, intentalo de mas tarde'), 'icon' => "warning"));
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request)
    {
        $id = $request->id;
        $num_ram = rand(1, 999);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filenamestore = $num_ram . time() . '.' . $extension;


        Storage::disk('public')->put(env('') . $filenamestore, fopen($request->file('image'), 'r+'), 'public');

        $status = Product::where('id', $id)->update(['img' => $filenamestore, 'link' => 'adminlte/img/products/']);
        if ($status) {
            return response(array('status' => 200, 'title' => 'Producto actualizado' ,'message' => 'Editaste el producto', 'space' => ' ','name' => $request->name, 'icon' => "success"));
        } else {
            return response(array('status' => 100, 'title' => __('Ops...') ,'message' => __('Ocurrio un error inesperado, intentalo de mas tarde'), 'icon' => "warning"));
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return Product::where('id',$id)->with('product_warehouses')->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product = Product::where('id', $product->id)->with(['product_warehouses'])->first();
        $product_warehouses = ProductWarehouse::where([['active', 1],['product_id', $product->id]])->with('warehouses')->get();
        $warehouses = Warehouse::where('active', 1)->with(['product_warehouses'])->get();
        // dd($product_warehouses);
        return view('admin.products.edit')
        ->with('product', $product)
        ->with('product_warehouses', $product_warehouses)
        ->with('warehouses', $warehouses);
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
        if($request['description'] > 400){
            return response(array('status' => 500, 'title' => 'Descripcion del producto' ,'message' => __('la descripcion es muy larga, intenta con algo mas corto'), 'icon' => "error"));
        }else{
            if(Product::where('code', $request["code"])->first()){
                return response(array('status' => 400, 'title' => 'Codigo del producto' ,'message' => __('Ya existe un producto con ese codigo'), 'icon' => "error"));
            }else{
                if(isset($request)){
                Product::where('id',$id)->update([
                    "name"          => $request["name"],
                    "price"         => $request["price"],
                    "quantity"      => $request["quantity"],
                    "description"   => $request["description"],
                ]);

                $warehouses = count($request['warehouses']);
                for($i = 0; $i < $warehouses; $i++){
                    if($product_warehouse = ProductWarehouse::where('product_id', $id)->where('warehouse_id', $request['warehouses'][$i])->first()){
                        $product_warehouse->product_id      = $id;
                        $product_warehouse->warehouse_id    = $request['warehouses'][$i];
                        $product_warehouse->update();
                    }else{
                        $prod_ware = new ProductWarehouse;
                        $prod_ware->quantity        = 0;
                        $prod_ware->product_id      = $id;
                        $prod_ware->warehouse_id    = $request['warehouses'][$i];
                        $prod_ware->save();
                    }

                }
                    return response(array('status' => 200, 'd' => array('id' => $id),'title' => 'Producto actualizado' ,'message' => 'Editaste el producto', 'space' => ' ','name' => $request->name, 'icon' => "success"));
                } else {
                    return response(array('status' => 100, 'title' => __('Ops...') ,'message' => __('Ocurrio un error inesperado, intentalo de mas tarde'), 'icon' => "warning"));
                }
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $name)
    {
        ProductWarehouse::where('product_id', $id)->delete();
        $product = Product::where('id', $id)->first();
        $product->delete();

        return array('status' => 200, 'title' => 'Producto eliminado' ,'message' => 'Elimiaste el producto', 'space' => ' ' ,'name' => $name, 'icon' => "success");

    }
}

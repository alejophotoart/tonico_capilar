<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index',[
            'products' => Product::where('active', 1 )->orderBy('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.products.create', [
            'product' => new Product
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
        if($request['description'] > 400){
            return response(array('status' => 500, 'title' => 'Descripcion del producto' ,'message' => __('la descripcion es muy larga, intenta con algo mas corto'), 'icon' => "error"));
                }else{
                if(Product::where('code', $request["code"])->first()){
                    return response(array('status' => 400, 'title' => 'Codigo del producto' ,'message' => __('Ya existe un producto con ese codigo'), 'icon' => "error"));
                }else{
                if (Product::create($request->all())) {
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

        return Product::where('id',$id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => Product::where('id', $product->id)->first()
        ]);
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
        if($request['description'] > 400){
            return response(array('status' => 500, 'title' => 'Descripcion del producto' ,'message' => __('la descripcion es muy larga, intenta con algo mas corto'), 'icon' => "error"));
        }else{
            if(Product::where('code', $request["code"])->first()){
                return response(array('status' => 400, 'title' => 'Codigo del producto' ,'message' => __('Ya existe un producto con ese codigo'), 'icon' => "error"));
            }else{
                if (Product::where('id',$id)->update([
                    "name"          => $request["name"],
                    "price"         => $request["price"],
                    "quantity"      => $request["quantity"],
                    "description"   => $request["description"],
                ])) {
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
        $product = Product::where('id', $id)->first();
        $product->delete();
        return array('status' => 200, 'title' => 'Producto eliminado' ,'message' => 'Elimiaste el producto', 'space' => ' ' ,'name' => $name, 'icon' => "success");

    }
}

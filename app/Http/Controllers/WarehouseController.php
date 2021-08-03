<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\StateWarehouse;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.warehouses.index',[
            'warehouses' => Warehouse::where('active', 1 )->orderBy('id')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::where('active', 1)->get();
        return($countries);
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
        if ($request) {
            $warehouse = Warehouse::create([
                'name'      => $request['name'],
                'city_id'   => $request['city_id']
            ]);
            return response(array('status' => 200, 'title' => 'Bodega creada' ,'message' => 'Creaste la bodega', 'space' => ' ','name' => $request->name, 'icon' => "success"));
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouse = Warehouse::where('id', $id)->with('city', 'state_warehouse')->first();
        $country = Country::where('active', 1)->get();
        $state = State::where('active', 1)->get();
        $cities = City::where('active', 1)->get();
        $state_warehouses = StateWarehouse::where('active', 1)->get();

        return([$warehouse, $country, $state, $cities, $state_warehouses]);
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
        if($request){
            $warehouse = Warehouse::where('id', $id)->update([
                'name'                  => $request['name'],
                'city_id'               => $request['city_id'],
                'state_warehouse_id'    => $request['state_warehouse_id']
            ]);
            return response(array('status' => 200, 'title' => 'Bodega Actualizada' ,'message' => 'Editaste la bodega', 'space' => ' ','name' => $request->name, 'icon' => "success"));
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
    public function destroy($id, $name)
    {
        $warehouse = Warehouse::where('id', $id)->first();
        $warehouse->delete();
        return array('status' => 200, 'title' => 'Bodega eliminada' ,'message' => 'Elimiaste la bodega', 'space' => ' ' ,'name' => $name, 'icon' => "success");
    }
}

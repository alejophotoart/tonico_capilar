<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Order;
use App\Models\TypeIdentification;
use App\Models\StateEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('role:2,1');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::where('id',auth::user()->id)->first()){
            $users = User::where([['id','<>',auth::user()->id],['identification', '<>',1144104341],['active', 1 ]])->orderBy('id')->with(['role'])->get();
            return view('admin.employees.index')->with('users', $users);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.employees.create', [
            'user' => new User,
            'roles' => Role::all(),
            'country' => Country::where('active', 1)->get(),
            'state' => State::where('active', 1)->get(),
            'cities' => City::where('active', 1)->get(),
            'type_identification' => TypeIdentification::where('active', 1)->get(),
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
        //dd($request->all());
        if(User::where('identification', $request["identification"])->first()){
            return response(array('status' => 500, 'title' => 'Identificacion' ,'message' => __('Ya existe un usuario con ese numero de identidad'), 'icon' => "error"));
        }else{
            if(User::where('email', $request["email"])->first()){
                return response(array('status' => 400, 'title' => 'Correo electronico' ,'message' => __('Ya existe un usuario con ese correo electronico'), 'icon' => "error"));
            }else{
                $user = User::create([
                    "type_identification_id"    => $request['type_identification_id'],
                    "identification"            => $request['identification'],
                    "name"                      => $request['name'],
                    "email"                     => $request['email'],
                    "phone"                     => $request['phone'],
                    "role_id"                   => $request['role_id'],
                    "city_id"                   => $request['city_id'],
                    "password"                  => Hash::make($request['password']),
                ]);
                return response(array('status' => 200, 'title' => 'Empleado creado' ,'message' => 'Creaste a', 'space' => ' ','name' => $request->name, 'icon' => "success"));
            }
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
        //muestra info en el modal
        $salesTot = Order::where('user_id',$id)->get();// estas consultas son para calcular cuantas ventas ha hecho el usuario
        $sales = Order::where([['user_id',$id],['state_order_id', 1]])->get();
        $salesReal = Order::where([['user_id',$id],['state_order_id', 3]])->get();
        $salesCan = Order::where([['user_id',$id],['state_order_id', 4]])->get();
        $salesPen = Order::where([['user_id',$id],['state_order_id', 5]])->get();
        $user = User::where('id',$id)->with(['role', 'type_identification', 'employee_state','city'])
        ->first();
        return([$user, $sales, $salesReal, $salesCan, $salesPen, $salesTot ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //dd($user);
        return view('admin.employees.edit', [
            'user' => User::where('id', $user->id)->with('city')->first(),
            'type_identification' => TypeIdentification::where('active', 1)->get(),
            'state_employee' => StateEmployee::where('active', 1)->get(),
            'roles' => Role::all(),
            'country' => Country::where('active', 1)->get(),
            'state' => State::where('active', 1)->get(),
            'cities' => City::where('active', 1)->with('state')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile($id)
    {
        $salesTot = Order::where('user_id',$id)->get();
        $sales = Order::where([['user_id',$id],['state_order_id', 1]])->get();
        $salesReal = Order::where([['user_id',$id],['state_order_id', 3]])->get();
        $salesCan = Order::where([['user_id',$id],['state_order_id', 4]])->get();
        $salesPen = Order::where([['user_id',$id],['state_order_id', 5]])->get();
        $user = User::where('id',$id)->with(['type_identification', 'employee_state','city'])->get();
        $rol = Role::all();
        $country = Country::where('active',1)->get();

        return([$user, $rol,  $country, $sales, $salesReal, $salesCan, $salesPen, $salesTot]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {
        //dd($request->all());
        if(User::where('identification' ,$request["identification"])->first()){
            return response(array('status' => 500, 'title' => 'Identificacion' ,'message' => __('Ya existe un usuario con ese numero de identidad'), 'icon' => "error"));
        }else{
            if(User::where('email', $request["email"])->first()){
                    return response(array('status' => 400, 'title' => 'Correo electronico' ,'message' => __('Ya existe un usuario con ese correo electronico'), 'icon' => "error"));
            }else{
                if(User::where('id', $id)->update([
                    "name"                      => $request["name"],
                    "phone"                     => $request["phone"],
                    "role_id"                   => $request["role_id"],
                    "city_id"                   => $request["city_id"],
                ])){
                    return response(array('status' => 200, 'd' => array('id' => $id, 'role' => $request['role_id']),'title' => 'Perfil editado' ,'message' => 'Actualizaste tu informacion', 'space' => ' ','name' => $request->name, 'icon' => "success"));
                }else{
                    return response(array('status' => 100, 'title' => __('Ops...') ,'message' => __('Ocurrio un error inesperado, intentalo de mas tarde'), 'icon' => "warning"));
                }
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateImageProfile(Request $request)
    {
        //dd($request);
        $id = $request->id;
        $num_ram = rand(1, 999);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filenamestore = $num_ram . time() . '.' . $extension;

        Storage::disk('user')->put(env('') . $filenamestore, fopen($request->file('image'), 'r+'), 'public');

        $status = User::where('id', $id)->update(['img' => $filenamestore, 'link' => '/adminlte/img/users/']);
        if ($status) {
            return response(array('status' => 200,'title' => 'Perfil editado' ,'message' => 'Actualizaste tu informacion', 'space' => ' ','name' => $request->name, 'icon' => "success"));
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
    public function update(Request $request, $id)
    {
        if(User::where('identification' ,$request["identification"])->first()){
                return response(array('status' => 500, 'title' => 'Identificacion' ,'message' => __('Ya existe un usuario con ese numero de identidad'), 'icon' => "error"));
            }else{
                if(User::where('email', $request["email"])->first()){
                        return response(array('status' => 400, 'title' => 'Correo electronico' ,'message' => __('Ya existe un usuario con ese correo electronico'), 'icon' => "error"));
                }else{
                    if(User::where('id', $id)->update([
                        "name"                      => $request["name"],
                        "phone"                     => $request["phone"],
                        "employee_state_id"         => $request["employee_state_id"],
                        "role_id"                   => $request["role_id"],
                        "city_id"                   => $request["city_id"],
                    ])){
                        return response(array('status' => 200, 'title' => 'Empleado editado' ,'message' => 'Editaste a', 'space' => ' ','name' => $request->name, 'icon' => "success"));
                    }else{
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
        $user = User::where('id', $id)->first();
        $user->delete();

        return array('status' => 200, 'title' => 'Empleado eliminado' ,'message' => 'Elimiaste a', 'space' => ' ' ,'name' => $name, 'icon' => "success");

    }
}

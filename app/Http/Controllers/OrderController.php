<?php

namespace App\Http\Controllers;

// use GuzzleHttp\Client;
use App\Models\Address;
use App\Models\Country;
use App\Models\Client;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PaymentType;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //vista de pedidos nuevos
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3){
            $orders = Order::where([['state_order_id','<>',2],['state_order_id','<>',3],['state_order_id','<>',4],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
            return view('admin.orders.index')->with('orders', $orders);
        }else{
            if(Auth::user()->role_id == 4){
                $orders = Order::where([['user_id',auth::user()->id],['state_order_id','<>',2],['state_order_id','<>',3],['state_order_id','<>',4],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
                return view('admin.orders.index')->with('orders', $orders);
            }
        }
    }

    public function progress()// vista de pedidos en procesos
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2  || Auth::user()->role_id == 3){
            $orders = Order::where([['state_order_id', 2],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
            $products = Product::get();
            return view('admin.orders.tables.in-progress')
            ->with('orders', $orders)
            ->with('products', $products);
        }else{
            if(Auth::user()->role_id == 4){
                $orders = Order::where([['user_id',auth::user()->id],['state_order_id', 2],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
                $products = Product::get();
                return view('admin.orders.tables.in-progress')
                ->with('orders', $orders)
                ->with('products', $products);
            }
        }
    }

    public function delivered()
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2  || Auth::user()->role_id == 3){
            $orders = Order::where([['state_order_id', 3],['active', 1]])->orderBy('id', 'desc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
            $products = Product::get();
            $sum = Order::where("state_order_id", 3)->select(Order::raw("(delivery_price + total) as total, id"))->get();
            return view('admin.orders.tables.delivered')
            ->with('orders', $orders)
            ->with('products', $products)
            ->with('total', $sum);
        }else{
            if(Auth::user()->role_id == 4){
                $orders = Order::where([['user_id',auth::user()->id],['state_order_id', 3],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
                $products = Product::get();
                $sum = Order::where("state_order_id", 3)->select(Order::raw("(delivery_price + total) as total, id"))->get();
                return view('admin.orders.tables.delivered')
                ->with('orders', $orders)
                ->with('products', $products)
                ->with('total', $sum);
            }
        }
    }

    public function canceled()
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3){
            $orders = Order::where([['state_order_id', 4],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
            $products = Product::get();
            return view('admin.orders.tables.canceled')
            ->with('orders', $orders)
            ->with('products', $products);
        }else{
            if(Auth::user()->role_id == 4){
                $orders = Order::where([['user_id',auth::user()->id],['state_order_id', 4],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
                $products = Product::get();
                return view('admin.orders.tables.canceled')
                ->with('orders', $orders)
                ->with('products', $products);
            }
        }
    }

    public function deposit()
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $orders = Order::where([['state_order_id', 7],['payment_type_id', 2],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
            return view('admin.orders.tables.deposit')->with('orders', $orders);
        }else{
            if(Auth::user()->role_id == 3){
                $orders = Order::where([['state_order_id', 6],['payment_type_id', 2],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
                return view('admin.orders.tables.deposit')->with('orders', $orders);
            }else{
                if(Auth::user()->role_id == 4){
                    $orders = Order::where([['user_id',auth::user()->id],['state_order_id', 7],['payment_type_id', 2],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
                    return view('admin.orders.tables.deposit')->with('orders', $orders);
                }
            }

        }
    }

    public function pending()
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3){
            $orders = Order::where([['state_order_id', 5],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
            return view('admin.orders.tables.pending')->with('orders', $orders);
        }else{
            if(Auth::user()->role_id == 4){
                $orders = Order::where([['user_id',auth::user()->id],['state_order_id', 5],['active', 1]])->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
                return view('admin.orders.tables.pending')->with('orders', $orders);
            }

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $user = User::where('id',$id)->with('role')->first();
        $country = Country::where('active',1)->get();
        $product = Product::where('active', 1)->get();
        $payment_type = PaymentType::where('active', 1)->get();

        return([$user, $country, $product, $payment_type]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search($id)
    {
        //dd($id);
        if(Client::where('identification', $id)->first())
        {
            $client_valid = Client::where('identification', $id)->with('address')->first();
            $cities = City::where('active', 1)->with('state')->get();
            return response(array('status' => 200, 'd' => array('client_data' => $client_valid, 'city' => $cities),'title' => 'Cliente encontrado' ,'message' => 'Se encontro el cliente', 'space' => ' ','name' => $client_valid->name, 'icon' => "success"));
        }else{
            return response(array('status' => 100, 'title' => 'Cliente nuevo' ,'message' => 'Este cliente no existe en nuestros registros', 'icon' => "info"));
        }
    }
    public function store(Request $request)
    {

        if(Client::where('id', $request['client_id'])->first())
        {
            $client = Client::where('id', $request['client_id'])->update([
                'identification'    => $request['identification'],
                'name'              => $request['name'],
                'phone'             => $request['phone'],
                'whatsapp'          => $request['whatsapp'],
            ]);
            $address = Address::create([
                'address'           => $request['address'],
                'neighborhood'      => $request['neighborhood'],
                'client_id'         => $request['client_id'],
                'city_id'           => $request['city_id'],
            ]);
            if($request['payment_type_id'] == 1){
                $order = Order::create([
                    'delivery_date'     => $request['delivery_date'],
                    'delivery_price'    => 10000,
                    'total'             => $request['total'],
                    'notes'             => $request['notes'],
                    'payment_type_id'   => $request['payment_type_id'],
                    'state_order_id'    => 1,
                    'client_id'         => $request['client_id'],
                    'user_id'           => $request['id'],
                    'address_id'        => $address['id'],
                    'city_id'           => $request['city_id'],
                    'active'            => 1,
                ]);
            }else{
                if($request['payment_type_id'] == 2){
                    $order = Order::create([
                        'delivery_date'     => $request['delivery_date'],
                        'delivery_price'    => 10000,
                        'total'             => $request['total'],
                        'notes'             => $request['notes'],
                        'payment_type_id'   => $request['payment_type_id'],
                        'state_order_id'    => 7,
                        'client_id'         => $request['client_id'],
                        'user_id'           => $request['id'],
                        'address_id'        => $address['id'],
                        'city_id'           => $request['city_id'],
                        'active'            => 1,
                    ]);
                }
            }

            $prod_quan = count($request['prod_quan'][0]);
            for($i = 0; $i < $prod_quan; $i++){
                $order_item             = new OrderItem;
                $order_item->quantity   = $request['prod_quan'][0][$i]; //posicion de las cantidades
                $order_item->product_id = $request['prod_quan'][1][$i]; //posicion de los id del producto
                $order_item->order_id   = $order['id'];
                $order_item->save();
            }
            $this->sendMessage($request);
            return response(array('status' => 200, 'd' => array('id' => $order->id),'title' => 'Pedido creado' ,'message' => 'Creaste el pedido de', 'space' => ' ','name' => $request->name, 'icon' => "success"));
        }else{
            $client = Client::create([
                'identification'    => $request['identification'],
                'name'              => $request['name'],
                'phone'             => $request['phone'],
                'whatsapp'          => $request['whatsapp'],
            ]);
            $address = Address::create([
                'address'           => $request['address'],
                'neighborhood'      => $request['neighborhood'],
                'client_id'         => $client['id'],
                'city_id'           => $request['city_id'],
            ]);

            if($request['payment_type_id'] == 1){
                $order = Order::create([
                    'delivery_date'     => $request['delivery_date'],
                    'delivery_price'    => 10000,
                    'total'             => $request['total'],
                    'notes'             => $request['notes'],
                    'payment_type_id'   => $request['payment_type_id'],
                    'state_order_id'    => 1,
                    'client_id'         => $client['id'],
                    'user_id'           => $request['id'],
                    'address_id'        => $address['id'],
                    'city_id'           => $request['city_id'],
                    'active'            => 1,
                ]);
            }else{
                if($request['payment_type_id'] == 2){
                    $order = Order::create([
                        'delivery_date'     => $request['delivery_date'],
                        'delivery_price'    => 10000,
                        'total'             => $request['total'],
                        'notes'             => $request['notes'],
                        'payment_type_id'   => $request['payment_type_id'],
                        'state_order_id'    => 7,
                        'client_id'         => $client['id'],
                        'user_id'           => $request['id'],
                        'address_id'        => $address['id'],
                        'city_id'           => $request['city_id'],
                        'active'            => 1,
                    ]);
                }
            }
            $product_quan = count($request['prod_quan'][0]);
            for($i = 0; $i < $product_quan; $i++){
                $order_item             = new OrderItem;
                $order_item->quantity   = $request['prod_quan'][0][$i]; //posicion de las cantidades
                $order_item->product_id = $request['prod_quan'][1][$i]; //posicion de los id del producto
                $order_item->order_id   = $order['id'];
                $order_item->save();
            }
            $this->sendMessage($request);
            return response(array('status' => 200, 'd' => array('id' => $order->id),'title' => 'Pedido creado' ,'message' => 'Creaste el pedido de', 'space' => ' ','name' => $request->name, 'icon' => "success"));
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendMessage($request)
    {
        $city = City::where('active', 1)->with('state')->get();
        $state = 0;
        $country = 0;
        foreach ($city as $c) {
           if($c->id == $request['city_id']){
                $city = $c->name;
                $state = $c->state->name;
                $country = $c->state->country->name;
           }
        }

        $product_name = [];
        // $text = "\nproductos: " . $product_name;
        $products = Product::where('active', 1)->get();
        foreach ($request['prod_quan'][1] as $pq) {
            foreach ($products as $p) {
                if($p->id == $pq){
                    array_push($product_name,$p->name);
                }
            }
        }
        $guia= $request['id'];
        $delivery_date = $request['delivery_date'];
        $name = $request['name'];
        $address = $request['address'];
        $neighborhood = $request['neighborhood'];
        $phone = $request['phone'];
        $whatsapp = $request['whatsapp'];
        $total = $request['total'];



        $data = [
            'phone' => '+573154709447', // Receivers phone
            'body' =>   "GUIA: " . $guia .
                        "\nPais: " . $country .
                        "\nDepartamento: " . $state .
                        "\nCiudad: " . $city .
                        "\nFecha de entrega: " . $delivery_date .
                        "\nNombre: " . $name .
                        "\nDireccion: " . $address .
                        "\nBarrio: " . $neighborhood .
                        "\nTelefono: " . $phone .
                        "\nWhatsapp: " . $whatsapp .
                        "\nTotal: " . $total,
        ];
        $json = json_encode($data);

        $token = 'z0g622gpapksd8xo';
        $instanceId = '312925';
        $url = 'https://api.chat-api.com/instance'.$instanceId.'/message?token='.$token;

        $options = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $json
            ]
        ]);
        // Send a request
        $result = file_get_contents($url, false, $options);


    }
    public function saveImage(Request $request)
    {
        //dd($request);
        $id = $request->id;
        $num_ram = rand(1, 999);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filenamestore = $num_ram . time() . '.' . $extension;


        Storage::disk('orders')->put(env('') . $filenamestore, fopen($request->file('image'), 'r+'), 'public');

        $status = Order::where('id', $id)->update(['img' => $filenamestore, 'link' => 'adminlte/img/orders/']);
        if ($status) {
            return response(array('status' => 200, 'title' => 'Pedido creado' ,'message' => 'Creaste el pedido de', 'space' => ' ','name' => $request->name, 'icon' => "success"));
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
        //dd($id);
        $order = Order::where('id', $id)->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->first();
        $product = Product::get();
        $addresses = Address::where('active', 1)->get();
        //dd($order_item);
        return ([$order, $addresses, $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $id)
    {
        $order = Order::where('id', $id->id)->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->first();
        $payment_type = PaymentType::where('active', 1)->get();
        $order_items = OrderItem::get(['id', 'order_id']);
        $address = Address::where('active', 1)->get();
        $country = Country::where('active', 1)->get();
        $products = Product::where('active', 1)->get();
        return view('admin.orders.edit')
        ->with('order', $order)
        ->with('address', $address)
        ->with('country', $country)
        ->with('payment_type', $payment_type)
        ->with('products', $products)
        ->with('order_items', $order_items);
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
        //dd($request->all());
        if(Order::where('id', $id)->first()){
                if(Order::where([['id', $id],['payment_type_id', 1], ['delivery_date', $request['delivery_date']]])->update([
                'delivery_date'=> $request['delivery_date'],
                // 'reason'            => $request['reason'],
                'delivery_price'    => 10000,
                'total'             => $request['total'],
                'notes'             => $request['notes'],
                'payment_type_id'   => $request['payment_type_id'],
                'state_order_id'    => 1,
                'client_id'         => $request['client_id'],
                'user_id'           => $request['user_id'],
                'address_id'        => $request['address_id'],
                'city_id'           => $request['city_id'],
                'active'            => 1,
            ])){

                }else{
                    if(Order::where([['id', $id],['payment_type_id', 1], ['delivery_date','<>',$request['delivery_date']]])->update([
                    'delivery_date'     => $request['delivery_date'],
                    // 'reason'            => $request['reason'],
                    'delivery_price'    => 10000,
                    'total'             => $request['total'],
                    'notes'             => $request['notes'],
                    'payment_type_id'   => $request['payment_type_id'],
                    'state_order_id'    => 5,
                    'client_id'         => $request['client_id'],
                    'user_id'           => $request['user_id'],
                    'address_id'        => $request['address_id'],
                    'city_id'           => $request['city_id'],
                    'active'            => 1,
                ])){

                }else{
                    if(Order::where([['id', $id],['payment_type_id', 2], ['delivery_date', $request['delivery_date']]])->first()->update([
                        'delivery_date'=> $request['delivery_date'],
                        // 'reason'            => $request['reason'],
                        'delivery_price'    => 10000,
                        'total'             => $request['total'],
                        'notes'             => $request['notes'],
                        'payment_type_id'   => $request['payment_type_id'],
                        'state_order_id'    => 7,
                        'client_id'         => $request['client_id'],
                        'user_id'           => $request['user_id'],
                        'address_id'        => $request['address_id'],
                        'city_id'           => $request['city_id'],
                        'active'            => 1,
                    ])){

                    }else{
                        if(Order::where([['id', $id],['payment_type_id', 2], ['delivery_date','<>',$request['delivery_date']]])->update([
                            'delivery_date'     => $request['delivery_date'],
                            // 'reason'            => $request['reason'],
                            'delivery_price'    => 10000,
                            'total'             => $request['total'],
                            'notes'             => $request['notes'],
                            'payment_type_id'   => $request['payment_type_id'],
                            'state_order_id'    => 5,
                            'client_id'         => $request['client_id'],
                            'user_id'           => $request['user_id'],
                            'address_id'        => $request['address_id'],
                            'city_id'           => $request['city_id'],
                            'active'            => 1,
                        ])){

                        }
                    }
                }
            }

        }

            $product_quan = count($request['prod_quan'][0]);
            OrderItem::where('order_id', $id)->delete();
            for($i = 0; $i < $product_quan; $i++){
                $order_i       = new OrderItem;
                $order_i->quantity   = $request['prod_quan'][0][$i]; //porder_isicion de las cantidades
                $order_i->product_id = $request['prod_quan'][1][$i]; //posicion de los id del producto
                $order_i->order_id   = $id;
                $order_i->save();
            }


            $client = Client::where('id', $request->client_id)->update([
                'identification'    => $request['identification'],
                'name'              => $request['name'],
                'phone'             => $request['phone'],
                'whatsapp'          => $request['whatsapp'],
            ]);

            $address = Address::where('id', $request->address_id)->update([
                'address'           => $request['address'],
                'neighborhood'      => $request['neighborhood'],
                'client_id'         => $request['client_id'],
                'city_id'           => $request['city_id'],
            ]);
            return response(array('status' => 200, 'id' => $id,'title' => 'Pedido Actualizado' ,'message' => 'Actualizaste el pedido de', 'space' => ' ','name' => $request->name, 'icon' => "success"));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function passedOrder($id)
    {
        $order = Order::where('id', $id)->update([
            'state_order_id'    => 6,
        ]);
        return array('status' => 200, 'title' => 'Deposito Aprobado' ,'message' => 'El pedido', 'message2' => 'esta aprobado para la entrega', 'space' => ' ' ,'id' => $id, 'icon' => "success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function processOrder($id)
    {
        $order = Order::where('id', $id)->update([
            'state_order_id'    => 2,
        ]);
        return array('status' => 200, 'title' => 'Pedido En proceso' ,'message' => 'El pedido', 'message2' => 'esta en proceso para su entrega', 'space' => ' ' ,'id' => $id, 'icon' => "success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deliveredOrder($id)
    {
        $order = Order::where('id', $id)->update([
            'state_order_id'    => 3,
        ]);
        return array('status' => 200, 'title' => 'Pedido Entregado' ,'message' => 'El pedido', 'message2' => 'ya se encuentra entregado', 'space' => ' ' ,'id' => $id, 'icon' => "success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $note)
    {
        //dd($id,$note);
        $order = Order::where('id', $id)->update([
            'state_order_id'    => 4,
            'reason'             => $note
        ]);
        return array('status' => 200, 'title' => 'Pedido cancelado' ,'message' => 'Cancelaste el pedido', 'space' => ' ' ,'id' => $id, 'icon' => "success");
    }
}

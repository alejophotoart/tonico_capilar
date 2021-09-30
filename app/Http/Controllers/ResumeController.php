<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    public function index()
    {
        $totalChats = 0;
        $replik = array();
        $chats = array();
        $timestamp = strtotime('today');
        $today2 = strtotime('today');
        $yesterday2 = strtotime('-1 day 23:59:59', $today2);
        $fromDate = strtotime('-2 month', $yesterday2);
        $token = 'c2zbqxn2i3oo3gj6';
        $instanceId = '312945';
        $url = 'https://api.chat-api.com/instance'.$instanceId.'/messages?token='.$token.'&limit=0&min_time='.$timestamp;
        $url2 = 'https://api.chat-api.com/instance'.$instanceId.'/messages?token='.$token.'&limit=0&min_time='.$fromDate.'&max_time='.$yesterday2;
        $result = file_get_contents($url); // Send a request
        $result2 = file_get_contents($url2);
        $data = json_decode($result, 1); // Parse JSON
        $data2 = json_decode($result2, 1); // Parse JSON

        for($i = 0; $i < count($data['messages']); $i++){
            $chatname = $data['messages'][$i]['chatName'];
            $text_section = substr($chatname, 1, 30);
            $with_space =str_replace(' ', '', $text_section);
            $chatName = $with_space."@c.us"; //change format chatName
            if($data['messages'][$i]['fromMe'] === false && $data['messages'][$i]['author'] == $data['messages'][$i]['chatId'] && $data['messages'][$i]['author'] == $chatName){
                for($e = 0; $e < count($data2['messages']); $e++){

                    if($data2['messages'][$e]['author'] == $data['messages'][$i]['author']){

                        $replik[$data['messages'][$i]['author']] = $data['messages'][$i]['author'];
                    }
                }

                if(isset($chats[$data['messages'][$i]['author']]))
                {
                    $chats[$data['messages'][$i]['author']]+=1;

                }else
                {
                    $chats[$data['messages'][$i]['author']]=1;
                }
            }
        }
        $clave = array_diff_key($chats, $replik);
        $totalChats = count($clave);
        /**
         *$sum = Order::where("state_order_id", 3)->select(Order::raw("(delivery_price + total) as total, id"))->get();
         *->with('total', $sum);
         */
        $subtotal = 0;
        $delivery = 0;
        $neto = 0;
        $cant = 0;
        $cantProd = 0;
        $prodCosto = 0;
        $totalCosto = 0;
        $countryXOrdes = [];

        $date = new Carbon('today');
        $date1 = $date->format('Y-m-d 00:00:00');
        $date2 = $date->format('Y-m-d 23:59:59');

        $products = Product::where('active', 1)->get();
        $countries = Country::where('active', 1)->get();
        $orders = Order::where([['state_order_id', 3],['created_at','>=',$date1],['created_at','<=',$date2],['active', 1]])->with(['city', 'order_items'])->get(['id', 'delivery_price', 'total', 'city_id', 'created_at']);

        for ($i=0; $i < count($countries); $i++) {
            for ($e=0; $e < count($orders); $e++) {
                if($countries[$i]->id == $orders[$e]->city->state->country->id){
                        $countryXOrdes[$i]['pais'] = $countries[$i]->name;

                        $subtotal = $subtotal + $orders[$e]->total;
                        $countryXOrdes[$i]['subtotal'] = $subtotal;

                        $cant++;
                        $countryXOrdes[$i]['sales'] = $cant;

                        $delivery = $delivery + $orders[$e]->delivery_price;
                        $countryXOrdes[$i]['delivery'] = $delivery;

                        for ($o=0; $o < count($orders[$e]->order_items); $o++) {
                            $cantProd = $cantProd + $orders[$e]->order_items[$o]->quantity;
                            $countryXOrdes[$i]['salesProd'] = $cantProd;

                            for ($c=0; $c < count($orders[$e]->order_items[$o]->product); $c++) {
                                $prodCosto = $prodCosto + ($orders[$e]->order_items[$o]->quantity * $orders[$e]->order_items[$o]->product[$c]->price);
                                $countryXOrdes[$i]['prodCosto'] = $prodCosto;
                            }
                        }
                        $neto = ($subtotal - $delivery) - $prodCosto;
                        $countryXOrdes[$i]['neto'] = $neto;
                    }
                }
            $subtotal = 0;
            $delivery = 0;
            $cant = 0;
            $neto = 0;
            $cantProd = 0;
            $prodCosto = 0;
        }

        foreach ($orders as $o) {
            $subtotal = $subtotal + $o->total;
            $delivery = $delivery + $o->delivery_price;
        }

        for ($p=0; $p < count($countryXOrdes); $p++) {
            $totalCosto = $totalCosto + $countryXOrdes[$p]['prodCosto'];
        }

        $totalNeto = ($subtotal - $delivery) - $totalCosto;

        return view('admin.resume.index')
        ->with('products', $products)
        ->with('countryXOrdes', $countryXOrdes)
        ->with('orders', $orders)
        ->with('subtotal', $subtotal)
        ->with('delivery', $delivery)
        ->with('totalCosto', $totalCosto)
        ->with('totalNeto', $totalNeto)
        ->with('clave', $clave)
        ->with('totalChats', $totalChats);
    }

    public function salesTable()
    {
        $orders = Order::where('active', 1)->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
        $orders_date = Order::where('state_order_id', 3)->where('created_at','>=',now()->subDay(7))->get([('created_at as fecha'), 'total', 'state_order_id']);
        $products = Product::where('active', 1)->get();
        $rolUser = Auth::user()->role_id;
        $idUser = Auth::user()->id;
        return response(array('status' => 200, 'orders' => $orders, 'dates' => $orders_date, 'products' => $products, 'rolUser' => $rolUser, 'idUser' => $idUser));
    }

    public function filter($date)
    {
        $subtotal =0;
        $delivery = 0;
        $neto = 0;
        $cant = 0;
        $cantProd = 0;
        $prodCosto = 0;
        $totalCosto = 0;
        $countryXOrdes = [];

        $dt = new Carbon($date);
        $date1 = $dt->format('Y-m-d 00:00:00');
        $date2 = $dt->format('Y-m-d 23:59:59');

        $countries = Country::where('active', 1)->get();
        $orders = Order::where([['state_order_id', 3],['created_at','>=',$date1],['created_at','<=',$date2],['active', 1]])->with(['city', 'order_items'])->get(['id', 'delivery_price', 'total', 'city_id', 'created_at']);

        // dd($orders);
        for ($i=0; $i < count($countries); $i++) {
            for ($e=0; $e < count($orders); $e++) {
                if($countries[$i]->id == $orders[$e]->city->state->country->id){
                        $countryXOrdes[$i]['pais'] = $countries[$i]->name;

                        $subtotal = $subtotal + $orders[$e]->total;
                        $countryXOrdes[$i]['subtotal'] = $subtotal;

                        $cant++;
                        $countryXOrdes[$i]['sales'] = $cant;

                        $delivery = $delivery + $orders[$e]->delivery_price;
                        $countryXOrdes[$i]['delivery'] = $delivery;

                        for ($o=0; $o < count($orders[$e]->order_items); $o++) {
                            $cantProd = $cantProd + $orders[$e]->order_items[$o]->quantity;
                            $countryXOrdes[$i]['salesProd'] = $cantProd;

                            for ($c=0; $c < count($orders[$e]->order_items[$o]->product); $c++) {
                                $prodCosto = $prodCosto + ($orders[$e]->order_items[$o]->quantity * $orders[$e]->order_items[$o]->product[$c]->price);
                                $countryXOrdes[$i]['prodCosto'] = $prodCosto;
                            }
                        }
                        $neto = ($subtotal - $delivery) - $prodCosto;
                        $countryXOrdes[$i]['neto'] = $neto;
                    }
                }
            $subtotal = 0;
            $delivery = 0;
            $cant = 0;
            $neto = 0;
            $cantProd = 0;
            $prodCosto = 0;
        }

        foreach ($orders as $o) {
            $subtotal = $subtotal + $o->total;
            $delivery = $delivery + $o->delivery_price;
        }
        for ($p=0; $p < count($countryXOrdes); $p++) {
            $totalCosto = $totalCosto + $countryXOrdes[$p]['prodCosto'];
        }

        $totalNeto = ($subtotal - $delivery) - $totalCosto;

        return response(array(
            'status' => 200,
            'countryXOrdes' => $countryXOrdes,
            'orders' => $orders,
            'subtotal' => $subtotal,
            'delivery' => $delivery,
            'totalCosto' => $totalCosto,
            'totalNeto' => $totalNeto
        ));

    }
}

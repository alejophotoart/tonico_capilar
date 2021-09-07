<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;
use PDF;

class ResumeController extends Controller
{
    public function index()
    {
        $totalChats = 0;
        $chats = array();
        $timestamp = strtotime('today');
        $token = 'c2zbqxn2i3oo3gj6';
        $instanceId = '312945';
        $url = 'https://api.chat-api.com/instance'.$instanceId.'/messages?token='.$token.'&min_time='.$timestamp;
        $result = file_get_contents($url); // Send a request
        $data = json_decode($result, 1); // Parse JSON

        foreach($data['messages'] as $message){
            $chatname = $message['chatName'];
            $text_section = substr($chatname, 1, 30);
            $with_space =str_replace(' ', '', $text_section);
            $chatName = $with_space."@c.us"; //change format chatName

            if($message['fromMe'] === false && $message['author'] == $message['chatId'] && $message['author'] == $chatName){
                if(isset($chats[$message['author']]))
                {
                    $chats[$message['author']]+=1;

                }else
                {
                    $chats[$message['author']]=1;
                }
                    // date_default_timezone_set('America/Bogota');
                    // echo "<br>";
                    // echo "Id:".$dialog['id']."<br>";
                    // echo "Name:".$dialog['name']."<br>";
                    // echo "Time:".$dialog['last_time']."<br>";
                    // echo "Sender:".$message['author']."<br>";
                    // echo "SenderName:".$message['senderName']."<br>";
                    // echo "chatId:".$message['chatId']."<br>";
                    // echo "Message: ".$message['body']."<br>";
                    // echo "chatName: ".$message['chatName']."<br>";
                    // echo "Time: ". date("d-m-y h:i:s", $message['time'])."<br>";
            }
        }
        $totalChats = count($chats);
        // echo "Chats hoy: ".count($chats). "\nTotal: ".$totalChats;
        /**
         *$sum = Order::where("state_order_id", 3)->select(Order::raw("(delivery_price + total) as total, id"))->get();
         *->with('total', $sum);
         */
        $subtotal =0;
        $delivery = 0;
        $neto = 0;
        $cant = 0;
        $countryXOrdes = [];

        $date = new Carbon('today');
        $date1 = $date->format('Y-m-d 00:00:00');
        $date2 = $date->format('Y-m-d 23:59:59');

        $products = Product::where('active', 1)->get();
        $countries = Country::where('active', 1)->get();
        $orders = Order::where([['state_order_id','<>', 4],['created_at','>=',$date1],['created_at','<=',$date2],['active', 1]])->with('city')->get(['id', 'delivery_price', 'total', 'city_id', 'created_at']);
        // dd($orders);

        for ($i=0; $i < count($countries); $i++) {
            for ($e=0; $e < count($orders); $e++) {
                if($countries[$i]->id == $orders[$e]->city->state->country->id){
                    $countryXOrdes[$i]['pais'] = $countries[$i]->name;

                    $subtotal = $subtotal + $orders[$e]->total;
                    $countryXOrdes[$i]['subtotal'] = $subtotal;

                    $delivery = $delivery + $orders[$e]->delivery_price;
                    $countryXOrdes[$i]['delivery'] = $delivery;

                    $cant++;
                    $countryXOrdes[$i]['sales'] = $cant;

                    $neto = $subtotal - $delivery;
                    $countryXOrdes[$i]['neto'] = $neto;
                }
            }
            $subtotal = 0;
            $delivery = 0;
            $cant = 0;
            $neto = 0;
        }
        // $json = json_encode($countryXOrdes);
        // dd($countryXOrdes);

        foreach ($orders as $o) {
            $subtotal = $subtotal + $o->total;
            $delivery = $delivery + $o->delivery_price;
        }
        // dd($subtotal, $delivery);

        for ($i=0; $i < count($orders); $i++) {
            $cant++;
        }
        $neto = $subtotal - $delivery;
        // dd($neto);

        return view('admin.resume.index')
        ->with('products', $products)
        ->with('countryXOrdes', $countryXOrdes)
        ->with('orders', $orders)
        ->with('subtotal', $subtotal)
        ->with('delivery', $delivery)
        ->with('neto', $neto)
        ->with('chats', $chats)
        ->with('totalChats', $totalChats);
    }

    public function salesTable()
    {
        $orders = Order::where('active', 1)->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
        $orders_date = Order::where('created_at','>=',now()->subDay(7))->get([('created_at as fecha'), 'total', 'state_order_id']);
        $products = Product::where('active', 1)->get();
        return response(array('status' => 200, 'orders' => $orders, 'dates' => $orders_date, 'products' => $products));
    }

    public function filter($date)
    {
        $subtotal =0;
        $delivery = 0;
        $neto = 0;
        $cant = 0;
        $countryXOrdes = [];

        $dt = new Carbon($date);
        $date1 = $dt->format('Y-m-d 00:00:00');
        $date2 = $dt->format('Y-m-d 23:59:59');

        $countries = Country::where('active', 1)->get();
        $orders = Order::where([['state_order_id','<>', 4],['created_at','>=',$date1],['created_at','<=',$date2],['active', 1]])->with('city')->get(['id', 'delivery_price', 'total', 'city_id', 'created_at']);

        for ($i=0; $i < count($countries); $i++) {
            for ($e=0; $e < count($orders); $e++) {
                if($countries[$i]->id == $orders[$e]->city->state->country->id){
                    $countryXOrdes[$i]['pais'] = $countries[$i]->name;

                    $subtotal = $subtotal + $orders[$e]->total;
                    $countryXOrdes[$i]['subtotal'] = $subtotal;

                    $delivery = $delivery + $orders[$e]->delivery_price;
                    $countryXOrdes[$i]['delivery'] = $delivery;

                    $cant++;
                    $countryXOrdes[$i]['sales'] = $cant;

                    $neto = $subtotal - $delivery;
                    $countryXOrdes[$i]['neto'] = $neto;
                }
            }
            $subtotal = 0;
            $delivery = 0;
            $cant = 0;
            $neto = 0;
        }
        // $json = json_encode($countryXOrdes);
        // dd($countryXOrdes);

        foreach ($orders as $o) {
            $subtotal = $subtotal + $o->total;
            $delivery = $delivery + $o->delivery_price;
        }
        // dd($subtotal, $delivery);

        for ($i=0; $i < count($orders); $i++) {
            $cant++;
        }
        $neto = $subtotal - $delivery;
        // dd($neto);

        return response(array('status' => 200, 'countryXOrdes' => $countryXOrdes, 'orders' => $orders, 'countries' => $countries, 'subtotal' => $subtotal,
            'delivery' => $delivery, 'neto' => $neto, 'cant' => $cant));

    }
    public function pdfProducts(){

        $products = Product::where('active', 1)->get();

        view()->share('products',$products);

        $pdf = PDF::loadView('admin.resume.percentProducts', $products);

        return $pdf->download('PercentProduct'.date('YmdHis').".pdf");
    }

    public function pdfMessagesWhatsapp(){

        $totalChats = 0;
        $chatss = array();
        $timestamp = strtotime('today');
        $token = 'c2zbqxn2i3oo3gj6';
        $instanceId = '312945';
        $url = 'https://api.chat-api.com/instance'.$instanceId.'/messages?token='.$token.'&min_time='.$timestamp;
        $result = file_get_contents($url); // Send a request
        $data = json_decode($result, 1); // Parse JSON

        foreach($data['messages'] as $message){
            $chatname = $message['chatName'];
            $text_section = substr($chatname, 1, 30);
            $with_space =str_replace(' ', '', $text_section);
            $chatName = $with_space."@c.us"; //change format chatName

            if($message['fromMe'] === false && $message['author'] == $message['chatId'] && $message['author'] == $chatName){
                if(isset($chats[$message['author']]))
                {
                    $chats[$message['author']]+=1;

                }else
                {
                    $chats[$message['author']]=1;
                }
                    // date_default_timezone_set('America/Bogota');
                    // echo "<br>";
                    // echo "Id:".$dialog['id']."<br>";
                    // echo "Name:".$dialog['name']."<br>";
                    // echo "Time:".$dialog['last_time']."<br>";
                    // echo "Sender:".$message['author']."<br>";
                    // echo "SenderName:".$message['senderName']."<br>";
                    // echo "chatId:".$message['chatId']."<br>";
                    // echo "Message: ".$message['body']."<br>";
                    // echo "chatName: ".$message['chatName']."<br>";
                    // echo "Time: ". date("d-m-y h:i:s", $message['time'])."<br>";
            }
        }
        $totalChats = count($chats);

        $items = [
            'totalChats' => $totalChats,
            'chats' => $chats
        ];

        $pdf = PDF::loadView('admin.resume.countMessagesWhatsApp', $items);

        return $pdf->download('MessagesWhatsApp'.date('YmdHis').".pdf");
    }

    public function pdfSalesToday()
    {
        $subtotal =0;
        $delivery = 0;
        $neto = 0;
        $cant = 0;
        $countryXOrdes = [];

        $date = new Carbon('today');
        $date1 = $date->format('Y-m-d 00:00:00');
        $date2 = $date->format('Y-m-d 23:59:59');

        $countries = Country::where('active', 1)->get();
        $orders = Order::where([['state_order_id','<>', 4],['created_at','>=',$date1],['created_at','<=',$date2],['active', 1]])->with('city')->get(['id', 'delivery_price', 'total', 'city_id', 'created_at']);
        // dd($orders);

        for ($i=0; $i < count($countries); $i++) {
            for ($e=0; $e < count($orders); $e++) {
                if($countries[$i]->id == $orders[$e]->city->state->country->id){
                    $countryXOrdes[$i]['pais'] = $countries[$i]->name;

                    $subtotal = $subtotal + $orders[$e]->total;
                    $countryXOrdes[$i]['subtotal'] = $subtotal;

                    $delivery = $delivery + $orders[$e]->delivery_price;
                    $countryXOrdes[$i]['delivery'] = $delivery;

                    $cant++;
                    $countryXOrdes[$i]['sales'] = $cant;

                    $neto = $subtotal - $delivery;
                    $countryXOrdes[$i]['neto'] = $neto;
                }
            }
            $subtotal = 0;
            $delivery = 0;
            $cant = 0;
            $neto = 0;
        }
        // $json = json_encode($countryXOrdes);
        // dd($countryXOrdes);

        foreach ($orders as $o) {
            $subtotal = $subtotal + $o->total;
            $delivery = $delivery + $o->delivery_price;
        }
        // dd($subtotal, $delivery);

        for ($i=0; $i < count($orders); $i++) {
            $cant++;
        }
        $neto = $subtotal - $delivery;

        $data = [
            'countryXOrdes' => $countryXOrdes,
            'subtotal'      => $subtotal,
            'delivery'      => $delivery,
            'neto'          => $neto
        ];

        $pdf = PDF::loadView('admin.resume.percentSalesToday', $data);

        return $pdf->download('SalesToday'.date('YmdHis').".pdf");
    }
}

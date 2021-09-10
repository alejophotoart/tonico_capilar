<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{

    public function pdfProducts(){

        $products = Product::where('active', 1)->get();

        view()->share('products',$products);

        $pdf = PDF::loadView('admin.resume.percentProducts', $products);

        return $pdf->download('PercentProduct'.date('YmdHis').".pdf");
    }

    public function pdfMessagesWhatsapp(){

        $totalChats = 0;
        $replik = array();
        $chats = array();
        $timestamp = strtotime('today');
        $today2 = strtotime('today');
        $yesterday2 = strtotime('-1 day 23:59:59', $today2);
        $fromDate = strtotime('-6 month', $yesterday2);
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

        $items = [
            'totalChats' => $totalChats,
            'clave' => $clave
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

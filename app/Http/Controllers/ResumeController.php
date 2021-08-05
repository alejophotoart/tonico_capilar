<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;

class ResumeController extends Controller
{
    public function index()
    {
        $token = 'c2zbqxn2i3oo3gj6';
        $instanceId = '312945';
        $url = 'https://api.chat-api.com/instance'.$instanceId.'/messages?token='.$token;
        $result = file_get_contents($url); // Send a request
        $data = json_decode($result, 1); // Parse JSON
        foreach($data['messages'] as $message){ // Echo every message
            echo "Sender:".$message['author']."<br>";
            echo "Message: ".$message['body']."<br>";
        }
        dd($message);

        $products = Product::where('active', 1)->get();
        return view('admin.resume.index')->with('products', $products);
    }

    public function salesTable()
    {
        $orders = Order::where('active', 1)->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
        $orders_date = Order::where('created_at','>=',now()->subDay(7))->get([('created_at as fecha'), 'total', 'state_order_id']);
        $products = Product::where('active', 1)->get();
        return response(array('status' => 200, 'orders' => $orders, 'dates' => $orders_date, 'products' => $products));
    }
}

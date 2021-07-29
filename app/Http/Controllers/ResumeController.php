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
        $products = Product::where('active', 1)->get();
        return view('admin.resume.index')->with('products', $products);
    }

    public function salesTable()
    {
        $orders = Order::where('active', 1)->orderBy('id', 'asc')->with(['payment_type', 'user', 'client', 'state_order', 'order_items', 'city'])->get();
        $orders_date = Order::where('created_at','>=',now()->subDay(7))->get([('created_at as fecha'), 'total']);
        return response(array('status' => 200, 'orders' => $orders, 'dates' => $orders_date));
    }
}

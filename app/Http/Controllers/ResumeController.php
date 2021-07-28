<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

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
        return response(array('status' => 200, 'orders' => $orders));
    }
}

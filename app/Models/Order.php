<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Order extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class)->with("address");
    }

    public function state_order()
    {
        return $this->belongsTo(StateOrder::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class)->with('product');
    }

    public function city()
    {
        return $this->belongsTo(City::class)->with("state");
    }

    public static function stateOrderId($value)
    {
        $config = Order::first();
        $config->update(['state_order_id' => $value]);

        return $config;
    }

}

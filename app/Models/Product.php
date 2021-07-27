<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Product extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function order_item()
    {
        return $this->belongsToMany(OrderItem::class);
    }

}

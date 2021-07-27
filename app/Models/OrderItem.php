<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class OrderItem extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasOne(Order::class);
    }
}

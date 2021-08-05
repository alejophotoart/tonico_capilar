<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;

    public function state_warehouse()
    {
        return $this->belongsTo(StateWarehouse::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class)->with("state");
    }
//
    public function product_warehouses()
    {
        return $this->hasMany(ProductWarehouse::class)->with("products");
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

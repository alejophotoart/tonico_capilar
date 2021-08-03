<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;


class ProductWarehouse extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class,'id','warehouse_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'id', 'product_id');
    }
}

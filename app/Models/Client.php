<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Client extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function city()
    {
        return $this->belongsTo(City::class)->with("state");
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}

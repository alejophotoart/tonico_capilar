<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function allCities($state_code){
        //dd($state_code);
        $cities = City::where("state_id", $state_code)->orderBy("name")->get();
        foreach ($cities as $key => $city) {
            $charset='UTF-8'; // o 'UTF-8'
            $str = iconv($charset, 'ASCII//TRANSLIT', $city->name);
            $str = str_replace("'",'',$str);
            $str = str_replace("~",'',$str);
            $cities[$key]->name = ucfirst(strtolower($str));
        }
        return array('r' => true, 'd' => array('cities' => $cities), 'm' => '');
    }
}

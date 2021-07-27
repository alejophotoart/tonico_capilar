<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
class StateController extends Controller
{
    public function allStates($country_code){
        $states = State::where("country_id", $country_code)->orderBy("name")->get();
        foreach ($states as $key => $state) {
            $charset='UTF-8'; // o 'UTF-8'
            $str = iconv($charset, 'ASCII//TRANSLIT', $state->name);
            $str = str_replace("'",'',$str);
            $str = str_replace("~",'',$str);
            $states[$key]->name = ucfirst(strtolower($str));
        }
        return array('r' => true, 'd' => array('states' => $states), 'm' => '');
    }
}

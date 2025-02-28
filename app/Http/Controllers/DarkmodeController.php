<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Darkmode;

class DarkmodeController extends Controller
{
    public function updateState( Request $request ){

        $darkmode = Darkmode::where('id', $request['id'])->first();
        $darkmode->status = $request['status'];
        $darkmode->update();

        return(array('status' => $darkmode->status));

    }
    
    public function getStatus( $id )
    {
        $darkmode = Darkmode::where('id', $id)->first();

        return( array( 'status' => $darkmode->status ) );
    }
}

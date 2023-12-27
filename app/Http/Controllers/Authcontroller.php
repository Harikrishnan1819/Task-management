<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authcontroller extends Controller
{
    public function register(){
        if(Auth::id()){
            $is_admin = Auth()->user()->is_admin;
            if($is_admin == true){
                return view('admin.index');
            }
            elseif($is_admin == false){
                return view('user.index');
            }
            else{
                return redirect()->back();
            }

        }
    }
}

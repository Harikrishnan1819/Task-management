<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){

        $users = User::with('tasks')->latest()->paginate(5);
        return view ('admin.userlist',compact('users'))
                    ->with('i',(request()->input('page',1)- 1) * 5);
    }

}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;


class MainController extends Controller
{

    function index(){
        return view('user.dashboard');
    }

}

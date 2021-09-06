<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebContents;
use App\Models\WebPhotos;
use Illuminate\Support\Facades\Hash;


class MainController extends Controller
{
    function index(){
        return view('admin.welcome');
    }

}

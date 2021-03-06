<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebContents;
use App\Models\WebPhotos;
use Illuminate\Support\Facades\Hash;


class IndexController extends Controller
{
    function index(){
        $image1 = WebPhotos::where('section','=','Galleries')->where('content1','=','Background')->get();
        $images1 = WebPhotos::where('section','=','Galleries')->where("content1","=","Screenshoots")->orderBy('updated_at','desc')->get();
        $admin = WebContents::where('section','=','Admins')->with('photos')->get();
        $news1 = WebContents::where('section','=','News')->orderBy('created_at','DESC')->with('photos')->take(5)->get();
        $link = WebContents::where('section','=','Links')->get();

        return view('welcome',['image1' => $image1,'images1' => $images1,
                                'admin'=> $admin,'news1' => $news1,
                                'link' => $link]);
    }

    function gallery($id){
        if($id == 1)
        {
            $gamemodes = "TTT";
        }else if($id == 2){
            $gamemodes = "Surf";
        }else if($id == 3){
            $gamemodes = "Deathrun";
        }else if($id == 4){
            $gamemodes = "PH";
        }else if($id == 5){
            $gamemodes = "Slender";
        }else if($id == 6){
            $gamemodes = "Sandbox";
        }
        $background = WebPhotos::where('section','=','Galleries')->where("content1","=","Background")->where("content2","=",$gamemodes)->get();
        $images = WebPhotos::where('section','=','Galleries')->where("content1","=","Screenshoots")->where("content2","=",$gamemodes)->get();
        return view('galleries',['images' => $images,'background' => $background]);
    }

}

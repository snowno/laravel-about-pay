<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(Auth::check() == false){
            return redirect('login');
        }else{
            return view('user/index')->withUser(\App\User::find($id));
        }

    }

    public function fb_fan_count($facebook_name){
        // Example: https://graph.facebook.com/digimantra
        $data = json_decode(file_get_contents("https://graph.facebook.com/".$facebook_name));
        echo $data->likes;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
//use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        return view('home')->withArticles(\App\Article::all())->simplePaginate(5);
        $articles = DB::table('articles')->paginate(10);
//        var_dump($article);exit;
        return view('home',compact('articles'));//
    }
}

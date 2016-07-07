<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Ins;
use Auth;
use Illuminate\Support\Facades\DB;

class InsController extends Controller
{
    public function index(){
//        var_dump(storage_path());exit;
        $inss = DB::table('ins')->get();

        foreach($inss as $k=>$v){
            if(!empty($v->tag)){
                $tags = explode(' ',$v->tag);
            }else{
                $tags = array();
            }
            $inss[$k]->tag = $tags;
        }

        return view('/ins/index',compact('inss'));
    }

    public function create(){
        if(Auth::check() == false){
            return redirect('login');
        }else{
            return view('ins/create');
        }

    }

    public function save(Request $request){
        $this->validate($request,[
            'image'=>'required',
        ]);

        $file = $request->file('image');
//        var_dump($file);exit;
        if($file->isValid()){

            $clientName = $file->getClientOriginalName();

            $tmpName = $file->getFileName();

            $realPath = $file->getRealPath();

            $extension = $file->getClientOriginalExtension();

            $mimeTye = $file->getMimeType();

            $newName = md5(date('ymdhis').$clientName).".".$extension;

            $path = $file->move(app_path().'/storage/uploads',$newName); //这里是缓存文件夹，存放的是用户上传的原图，这里要返回原图地址给flash做裁切用
        }
//        var_dump($newName);exit;
        $title = $request->get('title');
//        $tabs = explode("#",$title);
        preg_match_all("/\#(.*?)\#/", $title, $tags);
//        var_dump($tabs);exit;
        $count = count($tags[1]);
        $arr = array();
        foreach($tags[1] as $k=>$v){
            $arr[$k] = trim($v);
        }
        $tag = implode(' ',$tags[1]);
        $title = str_replace($tags[0],'',$title);
//        var_dump($title);exit;

        $ins = new Ins();
        $ins->title = $title;
        $ins->image = $newName;
        $ins->tag = $tag;
//        var_dump($ins->image);exit;
        $ins->user_id = $request->user()->id;
//        var_dump();exit;
//        dd($file->getPath());
        if($ins->save()){
            return redirect('ins');
        }else{
            return redirect()->back()->withInput()->withErrors('上传失败');
        }
    }

    public function detail($id)
    {
       return view('ins/detail')->withInss(Ins::find($id));
    }

    public function tag($tag,$id){
//       $tags =  DB::table('ins')->where('tag','like','%'.$tag.'%')->where('id','!=',$id)->get();
         $ins =  DB::table('ins')->get();
        $arr = array();
        foreach($ins as $k=>$v){
            $tags = $v->tag;
            $ex_tag = explode(' ',$tags);
            if(!empty($ex_tag)){
                foreach($ex_tag as $kk=>$vv){
                    if($vv==$tag){
                        $arr[] = $v->id;
                        $arr[$kk] = DB::table('ins')->where('id',$v->id)->get();
                    }
                }
            }
        }
         var_dump($arr);exit;
        return view('ins/tag');
    }
    public function tags(){
        $ins =  DB::table('ins')->get();
        $arr = array();
        foreach($ins as $k=>$v){
            $tags = $v->tag;
            $ex_tag = explode(' ',$tags);
            if(!empty($ex_tag)) {

                $arr[] = $ex_tag;
            }
        }
        $str = '';
        foreach($arr as $kk=>$vv){
            $str .= implode(',',$vv).',';
        }
        $arr = explode(',',$str);
        $arr = array_filter(array_unique($arr));
        $tag = '';
        foreach($arr as $k=>$v){
            $tag .=' <div style="width:50px;height:50px;background-color: lightpink">'.$v.'</div>';
        }
//        var_dump($arr);exit;

        return view('ins/tags',compact('tag'));

    }

}

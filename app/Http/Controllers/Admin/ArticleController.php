<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    public function index(){
        return view('admin/article/index')->withArticles(Article::all());
    }
    public function create(){
        return view('admin/article/create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:articles|max:255',
            'content' => 'required',
        ]);

        $article = new Article;
        $article->title = $request->get('title');
        $article->content = $request->get('content');
        $article->user_id = $request->user()->id;

        if ($article->save()) {
            return redirect('admin/article');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }
    public function edit($id){
        $article = Article::findOrFail($id);
        return view('admin/article/edit',compact('article'));//->withArticles(Article::get())
    }
    public function update(Request $request,$id)
    {
        $data = $request->all();
        unset($data['_method']);
        unset($data['_token']);
        try {
            if (Article::where('id', $id)->update($data))
            {
                return redirect('admin/article');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }

    }
    public function destroy($id){
        Article::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }
}

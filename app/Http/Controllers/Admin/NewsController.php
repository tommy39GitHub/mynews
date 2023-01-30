<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\News;
// News Modelが扱えるようになる

class NewsController extends Controller
{

    public function add()
    {
        return view('admin.news.create');
    }


    public function create(Request $request)
    {
        // validationを行う
        $this->validate($request, News::$rules);
        
        $news = new News;
        $form = $request->all();
        
        // フォームから画像が送信されたら、
        // 保存して$news->image_pathに画像のパスを保存
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $news->image_path = basename($path);
        } else {
            $news->image_path = null;
        }
        
        // フォームから送信されてきた_tokenを削除
        unset($form['_token']);
        // フォームから送信されてきたimageを削除
        unset($form['image']);
        
        // データベースに保存
        $news->fill($form);
        $news->save();
        
        // admin/news/createにリダイレクトする
        return redirect('admin/news/create');
    }
    
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
            if ($cond_title != '') {
                // 検索されたら検索結果を取得
                $posts = News::where('title', $cond_title)->get();
            } else {
                // それ以外はすべてのニュースを取得
                $posts = News::all();
            }
            return view('admin.news.index', ['posts' =>$posts, 'cond_title' => $cond_title]);
    }
    
    public function edit (Request $request)
    {
        // dd($request->id);
        // dd("editが呼ばれた");
        // news modelからデータを取得
        $news = News::find($request->id);
        // dd($news);
        if (empty($news)) {
            abort(404);
        }
        return view('admin.news.edit', ['news_form'=> $news]);
    }
    
    public function update(Request $request)
    {
        // validationをかける
        $this->validate($request, News::$rules);
        // news modelからデータを取得
        $news = News::find($request->id);
        // 送信されてきたフォームデータを格納
        $news_form = $request->all();
        
        if ($request->remove == 'true') {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $news_form['image_path'] = basename($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }
        unset($news_form['image']);
        unset($news_form['remove']);
        unset($news_form['_token']);
        
        // 該当データを上書き保存
        $news->fill($news_form)->save();
        
        return redirect('admin/news');
    }
    
    public function delete(Request $request)
    {
        // 該当するnews modelを取得
        $news = News::find($request->id);
        // 削除する
        $news->delete();
        return redirect('admin/news/');
    }
}

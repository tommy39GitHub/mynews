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
}

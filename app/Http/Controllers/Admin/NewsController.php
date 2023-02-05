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

// Requestはクラス、ブラウザを通してユーザーから送られる情報をすべて含んでいる
// オブジェクトを取得
    public function create(Request $request)
    {
        // validationを行う
        $this->validate($request, News::$rules);
        // $thisは、呼出元のオブジェクトへの参照。メソッドの中でクラスに定義された変数を使用したいとき
        $news = new News;
                // new:modelからインスタンスを生成するメソッド
        $form = $request->all();
        
        // フォームから画像が送信されたら、
        // 保存して$news->image_pathに画像のパスを保存
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $news->image_path = basename($path); /*$pathの中にはpublic/image/ハッシュ化
            されたファイル名。basename：ファイル名だけ取得するメソッドでファイル名
            だけを保存させる。そして、newsテーブルのimage_pathに代入*/
        } else {
            $news->image_path = null; /*newsテーブルのimage_pathカラムにnullを代入*/
        }
        /*issetメソッド：引数の中にデータがあるか否か
        fileメソッド：画像をアップロード
        storeメソッド：どこのフォルダにファイルを保存するかパス指定
    $form変数を使って代入したい、フォームから送信されてきた_tokenを削除*/
    
        unset($form['_token']);
        
        // フォームから送信されてきたimageを削除
        unset($form['image']);
        
        // 配列をカラムに代入 fillメソッド
        $news->fill($form);
        // データベースに保存
        $news->save();
        
        // admin/news/createにリダイレクトする
        return redirect('admin/news/create');
    }
    
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
            if ($cond_title != '') {
                /* 検索されたら検索結果を取得。$cond_titleにデータが存在する場合、
                whereメソッドを使うと、newsテーブルの中のtitleカラムで$cond_title
                （ユーザーが入力した文字）に一致するレコードをすべて取得。取得した
                テーブルを$posts変数に代入*/
                $posts = News::where('title', $cond_title)->get();
            } else {
                /* それ以外はすべてのニュースを取得。
                newsmodelを使ってデータベースに保存されているnewsテーブルのレコードをすべて取得、
                変数$postに代入*/
                $posts = News::all();
            }
            return view('admin.news.index', ['posts' =>$posts, 'cond_title' => $cond_title]);
            /*index.blade.phpに取得したレコード$postsと、ユーザが入力した文字列$cond_titleを渡しページを開く*/
    }
    
    public function edit (Request $request) 
    /* editActionは、編集画面*/
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
    /* updateActionは、 編集画面から送信されたフォームデータを処理*/
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
        // 削除する、deleteメソッド
        $news->delete();
        return redirect('admin/news/');
    }
}

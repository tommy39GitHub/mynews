<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\News;


class NewsController extends Controller
{
    public function index(Request $request)
    {
        $posts = News::all()->sortByDesc('updated_at');
        // sortByDescメソッド：カッコ内の値でソート
        
        if (count($posts) > 0) {
            $headline = $posts->shift();
            // shiftメソッド：配列の最初のデータを削除し、その値を返す
        } else {
            $headline = null;
        }
         // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        
        return view('news.index', ['headline' => $headline, 
        'posts' => $posts]);
    }
}

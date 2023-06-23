<?php
//閲覧者用
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\News;


class NewsController extends Controller
{
    public function index(Request $request)
    {
        $posts = News::all()->sortByDesc('updated_at');
                // News::all() すべてのnewsテーブルを取得
                            // sortByDesc(カッコ内の値(キー)-降順 でソート) 
        if (count($posts) > 0) {
            $headline = $posts->shift();
            // $headline = 最新の記事
                        // $post = 代入された最新の記事伊賀の記事
                                // shift(配列の最初のデータを削除し、その値を返す)
        } else {
            $headline = null;
        }
         // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        
        return view('news.index', ['headline' => $headline, 'posts' => $posts]);
    }
}

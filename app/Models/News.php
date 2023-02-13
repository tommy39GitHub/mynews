<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');
    
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    
    // newsmodel に関連づけを行う    
    public function histories()
    {
        return $this->hasMany('App\Models\History');
        // hasManyメソッド：一覧を表示。newsテーブルに関連付いているhistoriesテーブルをすべて取得
    }
}

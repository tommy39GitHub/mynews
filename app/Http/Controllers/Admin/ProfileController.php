<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profile;
// profile modelを使う
use App\Models\Profilerecord; //追加　課題１２

use Carbon\Carbon; //追加　課題１２


class ProfileController extends Controller
{
    
   public function add() //プロフィールの追加
    {
        return view('admin.profile.create');
    }

    public function edit(Request $request) //プロフィールの編集
    {
        $profile = Profile::find($request->id);
        // dd($profile);
        
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form'=> $profile]);
    }

    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        $profile = Profile::find($request->id);
        $profile_form = $request->all();
        
        unset($profile_form['image']);
        unset($profile_form['remove']);
        unset($profile_form['_token']);
        
        $profile->fill($profile_form)->save();
        // dd($profile_form);
        
        //追加　課題１２
        $profilerecord = new Profilerecord();
        $profilerecord->profile_id = $profile->id;
        $profilerecord->edited_at = Carbon::now();
        // dd($historyforprofile);    
        $profilerecord->save();
        
        return redirect('admin/profile');
    } 
    
    public function create(Request $request)
    {
        // validationを行う
        $this->validate($request, Profile::$rules);
        
        $profile = new Profile;       
        $form = $request->all();
        
        
        // フォームから送信されてきた_tokenを削除
        unset($form['_token']);
        
        
        // フォームから送信されてきたimageを削除
        unset($form['image']);
        
        
        // データベースに保存
        $profile->fill($form);
        $profile->save();
        
        // admin/profile/createにリダイレクトする
        return redirect('admin/profile/create');
    }
    
    public function delete(Request $request)
    {
        // 該当するnews modelを取得
        $profile = profile::find($request->id);
        // 削除する、deleteメソッド
        $profile->delete();
        return redirect('admin/profile/');
    }
    
}

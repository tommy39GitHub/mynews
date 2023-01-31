<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profile;

class ProfileController extends Controller
{
    
   public function add()
    {
        return view('admin.profile.create');
    }

    public function edit()
    {
        return view('admin.profile.edit');
    }

    public function update()
    {
        return redirect('admin/profile/edit');
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
}

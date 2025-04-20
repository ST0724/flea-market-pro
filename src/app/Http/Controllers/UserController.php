<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Http\Requests\ProfileEditRequest;

class UserController extends Controller
{
    // プロフィール編集画面
    public function profileEdit(Request $request){
        $user = Auth::user();

        if(is_null($user['image'])){
            $image = 'profile_icon.jpg';
            Auth::user()->update(['image' => $image]);
        }

        return view('profile_edit', compact('user'));
    }

    public function profileEditUpdate(ProfileEditRequest $request){
        $user = $request->only(['name', 'post_code', 'address', 'building']);

        if ($request->hasFile('image')) {
            // 新しい画像がアップロードされた場合
            $fileName = time() . '.' . $request->image->extension();
            $path = $request->file('image')->storeAs('images', $fileName, 'public');
            $user['image'] = $path;
        } elseif ($request->has('image')) {
            // ファイルがアップロードされていない場合
            // 既存の画像を保持
            $user['image'] = Auth::user()->image;
        }

        Auth::user()->update($user);
        return redirect('/');
    }

    // プロフィール画面
    public function profile(Request $request){
        $user = Auth::user();
        $tab = $request->tab;
        if ($tab === 'buy') {
            $items = Item::where('purchaser_id', Auth::id())->get();
        }else if($tab === 'sell'){
            $items = Item::where('seller_id', Auth::id())->get();
        }else if($tab === 'haggling'){
            $items = collect();
        }else{
            $items = collect();
        }
        return view('profile',compact('items', 'user'));
    }

    // チャット画面
    public function chat($item_id){
        $item = Item::with('hagglingUser')->find($item_id);
         $item = Item::find($item_id);
         $user = Auth::user();
        return view('chat', compact('item','user'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;

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

    public function profileEditUpdate(Request $request){
        $user = $request->only(['name', 'post_code', 'address', 'building', 'image']);
        if(is_null($user['image'])){
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
        }else{
            $items = collect();
        }
        return view('profile',compact('items', 'user'));
    }
}

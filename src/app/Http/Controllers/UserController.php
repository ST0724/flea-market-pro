<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\Message;
use App\Http\Requests\ProfileEditRequest;
use App\Http\Requests\MessageRequest;

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
            $items = Item::whereHas('transactions', function ($query) {
                $query->where(function ($q) {
                    $q->where('seller_id', Auth::id())
                    ->orWhere('purchaser_id', Auth::id());
                });
            })->with(['transactions' => function($q) {
                $q->where(function ($q2) {
                    $q2->where('seller_id', Auth::id())
                    ->orWhere('purchaser_id', Auth::id());
                });
            }])->get();
        }else{
            $items = collect();
        }
        return view('profile',compact('items', 'user'));
    }


    // チャット画面
    public function chat($transaction_id){
        $transaction = Transaction::find($transaction_id);
        $item = Item::find($transaction->item_id);
        $user = Auth::user();
        $messages = Message::with('user')->where('transaction_id', $transaction_id)->get();

        //サイドバーに表示する商品の取得
        $others = Item::whereHas('transactions', function ($query) {
                $query->where(function ($q) {
                    $q->where('seller_id', Auth::id())
                    ->orWhere('purchaser_id', Auth::id());
                });
            })->with(['transactions' => function($q) {
                $q->where(function ($q2) {
                    $q2->where('seller_id', Auth::id())
                    ->orWhere('purchaser_id', Auth::id());
                });
            }])->get();

            // $transaction_idと一致するTransactionを持つItemを除外
            $others = $others->reject(function($item) use ($transaction_id) {
                return $item->transactions->contains('id', $transaction_id);
            })->values(); 

        if($transaction['seller_id'] === Auth::id()){
            //自分が出品者の場合
            $target = User::find($transaction->purchaser_id);
        }else{
            //自分が購入者の場合
            $target = User::find($transaction->seller_id);
        }

        return view('chat', compact('item','user', 'target', 'transaction_id', 'others', 'messages'));
    }

    
    public function chatStore(MessageRequest $request){
        $transaction_id = $request->input('transaction_id');
        $message = $request->only(['text']);
        $message['user_id'] = Auth::id();
        $message['transaction_id'] = $transaction_id;

        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->file('image')->extension();
            $path = $request->file('image')->storeAs('images', $fileName, 'public');
            $message['image'] = $path;
        }

        Message::create($message);
        return redirect("/chat/{$transaction_id}");
    }
}
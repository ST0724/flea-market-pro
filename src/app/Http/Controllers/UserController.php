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
use Illuminate\Support\Facades\DB;

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
        $user_id = Auth::id();
        $tab = $request->tab;

        if ($tab === 'buy') {
            $items = Item::where('purchaser_id', $user_id)->get();
        }else if($tab === 'sell'){
            $items = Item::where('seller_id', $user_id)->get();
        }else if($tab === 'haggling'){
            $items = Item::whereHas('transactions', function ($query) use ($user_id) {
                $query->where(function ($q) use ($user_id) {
                    $q->where('seller_id', $user_id)
                    ->orWhere('purchaser_id', $user_id);
                })
                ->where('status', '!=', 2)
                ->where(function ($q) use ($user_id) {
                    $q->where('purchaser_id', '!=', $user_id)
                    ->orWhere('status', '!=', 1);
                });
            })->with(['transactions' => function($q) use ($user_id) {
                $q->where(function ($q2) use ($user_id) {
                    $q2->where('seller_id', $user_id)
                    ->orWhere('purchaser_id', $user_id);
            })->with('messages');
            }])->addSelect([
                'latest_message' => Message::select(DB::raw('MAX(created_at)'))
                    ->whereHas('transaction', function ($q) use ($user_id) {
                        $q->whereColumn('transactions.item_id', 'items.id')
                        ->where(function ($q2) use ($user_id) {
                            $q2->where('seller_id', $user_id)
                                ->orWhere('purchaser_id', $user_id);
                        });
                    })
            ])->orderByDesc('latest_message')->get();
        }else{
            $items = collect();
        }

        if ($user['rating_count'] > 0) {
            $rating = round($user['rating_sum'] / $user['rating_count']);
        } else {
            $rating = 0;
        }

        $total_unread_count = 0;
        foreach ($items as $item) {
            $unread_count = 0;
            foreach ($item->transactions as $transaction) {
                $unread_count += $transaction->messages->where('is_read', false)
                                                    ->where('user_id', '!=', $user_id)
                                                    ->count();
            }
            $item->unread_message_count = $unread_count;
            $total_unread_count += $unread_count;
        }

        return view('profile',compact('items', 'user', 'rating', 'total_unread_count'));
    }


    // チャット画面
    public function chat($transaction_id){
        $transaction = Transaction::find($transaction_id);
        $item = Item::find($transaction->item_id);
        $user = Auth::user();
        $user_id =Auth::id();
        $messages = Message::with('user')->where('transaction_id', $transaction_id)->get();

        //サイドバーに表示する商品の取得
        $others = Item::whereHas('transactions', function ($query) use ($user_id) {
            $query->where(function ($q) use ($user_id) {
                $q->where('seller_id', $user_id)
                ->orWhere('purchaser_id', $user_id);
            })
            ->where('status', '!=', 2)
            ->where(function ($q) use ($user_id) {
                $q->where('purchaser_id', '!=', $user_id)
                ->orWhere('status', '!=', 1);
            });
        })
        ->with(['transactions' => function($q) use ($user_id) {
            $q->where(function ($q2) use ($user_id) {
                $q2->where('seller_id', $user_id)
                ->orWhere('purchaser_id', $user_id);
            });
        }])
        ->get();

            //$transaction_idと一致するTransactionを持つItemを除外
            $others = $others->reject(function($item) use ($transaction_id) {
                return $item->transactions->contains('id', $transaction_id);
            })->values(); 

        if($transaction['seller_id'] === Auth::id()){
            $target = User::find($transaction->purchaser_id);
        }else{
            $target = User::find($transaction->seller_id);
        }

        //相手のメッセージを既読にする
        Message::where('transaction_id', $transaction_id)
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat', compact('item','user', 'target', 'transaction_id', 'transaction', 'others', 'messages'));
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

    public function chatDestroy(Request $request){
        Message::find($request->message_id)->delete();
        $transaction_id = $request->input('transaction_id');
        return redirect("/chat/{$transaction_id}");
    }

    public function chatRating(Request $request){
        $transaction = Transaction::find($request->input('transaction_id'));
        $star = $request->input('rating');
        
        if($transaction->seller_id === Auth::id()){
            // 自分が出品者の場合
            $target = User::find($transaction->purchaser_id);
            $transaction->status = 2;
        } else {
            // 自分が購入者の場合
            $target = User::find($transaction->seller_id);
            $transaction->status = 1;
        }

        $transaction->save();

        $target['rating_sum'] = $target['rating_sum'] + $star;
        $target->rating_count++;
        
        $target->update([
            'rating_sum' => $target->rating_sum,
            'rating_count' => $target->rating_count,
        ]);

        return redirect('/');
    }
}
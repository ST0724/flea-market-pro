<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Transaction;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\SellRequest;

class ItemController extends Controller
{
    // 商品一覧画面
    public function index(Request $request){
        $user_id = Auth::id();
        $user = Auth::user();
        $tab = $request->tab;

        if ($tab === 'mylist') {
            $items = Item::whereHas('likes', function($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->get();
        }else{
            $items = Item::where('seller_id', '!=', $user_id)->get();
        }
    
        return view('index', compact('items'));
    }

    public function indexSearch(Request $request){
        // 検索が空欄の場合はリダイレクト
        if(is_null($request->keyword)){
            return redirect('/');
        }
        $user_id = Auth::id();
        $items = Item::KeywordSearch($request->keyword)->where('seller_id', '!=', $user_id)->get();
        return view('index', compact('items'));
    }

    // 商品詳細画面
    public function item($item_id){
        $item = Item::with('condition','likes')->find($item_id);
        $categories = Item::findOrFail($item_id)->categories;
        $comments = Comment::with('user')->where('item_id', $item_id)->get();
        $count_comments = Comment::where('item_id', $item_id)->count();
        $count_likes = Like::where('item_id', $item_id)->count();
        $isLiked = $item->isLikedByUser(Auth::user());
        return view('item', compact('item', 'categories', 'count_comments', 'count_likes', 'comments', 'isLiked'));
    }

    public function comment(CommentRequest $request, $item_id){
        $comment = $request->only(['text']);
        $comment['user_id'] = Auth::id();
        $comment['item_id'] = $item_id;
        Comment::create($comment);
        return redirect("/item/{$item_id}");
    }

    public function like($item_id){
        $user = Auth::id();
        $like = Like::where('user_id', $user)->where('item_id', $item_id)->first();

        if ($like) {
            $like->delete();
        } else {
            $like['user_id'] = Auth::id();
            $like['item_id'] = $item_id;
            Like::create($like);
        }

        return redirect("/item/{$item_id}");
    }

    // 購入画面
    public function purchase($item_id){
        $item = Item::find($item_id);
        $user = Auth::user();
        $destination = session('destination');
        session()->forget('destination');
        if (is_null($destination)) {
            $user = Auth::user();
            $destination['address'] = $user->address;
            $destination['post_code'] = $user->post_code;
            $destination['building'] = $user->building;
        }
        return view('purchase', compact('item', 'user', 'destination'));
    }

    public function purchaseStore(PurchaseRequest $request, $item_id){
        $destination = $request->only(['address', 'post_code', 'building']);
        $destination['item_id'] = $item_id;
        Destination::create($destination);

        $item['purchaser_id'] = Auth::id();
        Item::find($item_id)->update($item);

        $item = Item::find($item_id);

        $transaction = Transaction::create([
            'item_id'      => $item_id,
            'purchaser_id' => Auth::id(),
            'seller_id'    => $item->seller_id,
        ]);

        $transaction_id = $transaction->id;
        return redirect("/chat/{$transaction_id}");
    }

    // 住所変更ページ
    public function address($item_id){
        $item = Item::find($item_id);
        return view('address', compact('item'));
    }

    public function addressStore(AddressRequest $request, $item_id){
        $destination = $request->only(['address', 'post_code', 'building']);
        $destination['item_id'] = $item_id;
        session(['destination' => $destination]);
        return redirect("/purchase/{$item_id}");
    }

    // 出品画面
    public function sell(){
        $conditions = Condition::all();
        $categories = Category::all();
        return view('sell', compact('conditions', 'categories'));
    }

    public function sellStore(SellRequest $request){
        $checkedCategories = $request->input('categories', []);
        $itemData = $request->only(['name', 'condition_id', 'description', 'price']);
        $itemData['seller_id'] = Auth::id();
        
        $fileName = time() . '.' . $request->image->extension();
        $path = $request->file('image')->storeAs('images', $fileName, 'public');
        $itemData['image'] = $path;

        $item = Item::create($itemData);

        if (!empty($checkedCategories)) {
            $item->categories()->attach($checkedCategories);
        }

        return redirect('/mypage');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // 商品一覧画面
    public function index(){
        $items = Item::all();
        return view('index', compact('items'));
    }

    // 商品詳細画面
    public function item($item_id){
        $item = Item::find($item_id);
        return view('item', compact('item'));
    }

    // 出品画面
    public function sell(){
        $conditions = Condition::all();
        return view('sell', compact('conditions'));
    }

    public function sellStore(Request $request){
        $item = $request->only(['image', 'name', 'condition_id', 'description', 'price']);
        $item['seller_id'] = Auth::id();
        Item::create($item);
        return redirect('/mypage');
    }
}

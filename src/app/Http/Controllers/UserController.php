<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function profileEdit(Request $request){
        $user = Auth::user();
        return view('profile_edit', compact('user'));
    }

    public function profileEditUpdate(Request $request){
        $user = $request->only(['name', 'post_code', 'address', 'building', 'image']);
        Auth::user()->update($user);
        return redirect('/');
    }
}

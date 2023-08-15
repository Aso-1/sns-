<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class FollowController extends Controller
{
    public function store($userId)//フォロー
    {
        Auth::user()->follows()->attach($userId);
        return redirect();
    }
    public function destroy($userId)//フォロー解除
    {
        Auth::user()->follows()->detach($userId);
        return redirect();
    }
}

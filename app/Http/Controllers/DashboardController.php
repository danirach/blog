<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function show()
    {
        $userId = auth()->id();
        $post_user =  Post::with('user','like')->get();
        $images = User::where('id',$userId)->get();
        // $user = User::where('id', $userId)->first();
                                // dd($post_user[0]->like->count());
        return view('dashboard',compact('post_user','images'));
    }
}

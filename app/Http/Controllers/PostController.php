<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function show()
    {
        $userId = auth()->id();
        $post_user =  Post::with('user','like')->where('user_id',$userId)->get();
        $user = User::where('id', $userId)->first();
        // dd(strlen($post_user[2]->content));
        return view('post',compact('post_user'));
    }

    public function create(Request $request){
        $post = new Post();

        $post->user_id = $request->user_id;
        $post->title = $request->title;
        $post->content = $request->content;

        $post->save();

        return redirect('/post');
        // dd($request);
    }

    public function detailPost(string $id){
        // $userId = auth()->id();
        $post_detail =  Post::with('user','like')->where('id',$id)->get();
        $comment = Comment::with('post','user','reply')->where('post_id',$id)->get();
        $reply = Reply::with('user','comment','post')->where('post_id',$id)->get();

        // dd($comment[0]->reply[0]->reply);
        return view('post-detail',compact('post_detail','comment','reply'));
    }

    public function createComment(Request $request){
        $comment = new Comment();

        $comment->user_id = $request->user_id;
        $comment->comment = $request->comment;
        $comment->post_id = $request->post_id;

        $comment->save();

        return redirect()->route('post-detail', ['id' => $request->post_id]);
    }

    public function createReply(Request $request){
        $reply = new Reply();

        $reply->user_id = $request->user_id;
        $reply->reply = $request->reply;
        $reply->comment_id = $request->comment_id;
        $reply->post_id = $request->post_id;

        $reply->save();

        return redirect()->route('post-detail', ['id' => $request->post_id]);
    }

    public function toggleLike(Request $request)
    {
        // Logika untuk menambah atau menghapus like dari database
        $postId = $request->input('post_id');
        $userId = auth()->id();

        $like = Like::where('post_id', $postId)
                    ->where('user_id', $userId)
                    ->first();
        $like_count = Like::where('post_id', $postId)->count();

        if ($like) {
            $like->delete();
            $message = 'Unlike success.';
        } else {
            Like::create(['post_id' => $postId, 'user_id' => $userId]);
            $message = 'Like success.';
        }

        return response()->json([
            'message' => $message,
            'likeCount' =>$like_count
        ]);
    }
}

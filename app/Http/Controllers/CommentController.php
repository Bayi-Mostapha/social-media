<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Events\CommentEvent;
use App\Models\Notification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function store(Request $request){
        $validatedData = $request->validate([
            'comment' => 'required|string',
            'pid' => 'required|exists:posts,id',
        ]);
    
        $content = $validatedData['comment'];
        $post_id = $validatedData['pid'];
        $user_id = auth()->id();

        Post::findOrFail($post_id);

        $comment = Comment::create(compact('user_id', 'post_id', 'content'));
        event(new CommentEvent($comment->post->user_id, $comment->user->name));

        $author_id = $user_id;
        
        Notification::create(compact('author_id', 'post_id'));

        return redirect()->back()->with('success', 'comment created successfully');
    }   

    public function destroy(Comment $comment, Request $request){
        $this->authorize('delete', $comment);
        
        if ($comment) {
            $comment->delete();
        }
        return redirect()->back()->with('success', 'comment deleted successfully');
    }
}

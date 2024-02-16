<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function index(){
        $posts = auth()->user()->posts;
        return view('posts.index', compact('posts'));
    }

    public function create(Request $request){
        return view('posts.create');
    }
    
    public function store(Request $request){
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Adjust the mime types and file size as needed
        ]);
    
        $title = $validatedData['title'];
        $body = $validatedData['body'];
        $image = null;
        $user_id = auth()->id();
        
        if($request->hasFile('image'))
            $image = $request->file('image')->store('post-images', 'public');
        //laravel creates a unique file name
        //storeAs('','filename','') to create your own name

        Post::create(compact('title', 'body', 'image', 'user_id'));

        return redirect()->route('posts.index')->with('success', 'post created successfully');
    }

    public function edit(Post $post){
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Post $post, Request $request){
        $this->authorize('update', $post);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $title = $validatedData['title'];
        $body = $validatedData['body'];
        $image = $post->image;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('post-images', 'public');
        }

        $post->update(compact('title', 'body', 'image'));
    
        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }    

    public function destroy(Post $post, Request $request){
        $this->authorize('delete', $post);
        if ($post) {
            $post->delete();
        }
        return redirect()->route('posts.index')->with('success', 'post deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Post;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }
    public function index(Request $request)
    {
        if($request->search)
        {
            $posts = Post::where('title' , 'like' , '%' . $request->search . '%' )
            ->orWhere('body','like', '%' . $request->serach . '%')->latest()->get();
        }
        else
        {
            $posts = Post::latest()->get();
        }
        return view('blogPost.blog',compact('posts'));
    }

    public function create()
    {
        return view('blogPost.create-blog-post');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required | image',
            'body'  => 'required',
        ]);

        $title = $request->input('title');
        $postId = Post::latest()->take(1)->first()->id + 1;
        $slug  = str::slug($title,'-'). '-' . $postId;
        $user_id  = Auth::user()->id;
        $body  = $request->input('body');

        //File upload
        $imagePath = 'storage/' . $request->file('image')->store('postsImages','public');
        $post = new Post();
        $post->title = $title;
        $post->slug  = $slug;
        $post->user_id = $user_id;
        $post->body   = $body;
        $post->imagePath = $imagePath;
        $post->save();
        return redirect()->back()->with('status','Post Create Successfully'); 
    }

    // public function show($slug)
    // {
    //     $post = Post::where('slug',$slug)->first();
    //     return view('blogPost.singleBlogPost', compact('post'));
    // }
    
    //Using Route model binding
    public function show(Post $post)
    {
        return view('blogPost.singleBlogPost',compact('post'));
    }

    // blog edit function create
    public function edit(Post $post)
    {
        if(auth()->user()->id !== $post->user->id)
        {
            abort(403);
        }
        return view('blogPost.editBlogPost',compact('post'));
    }

    // blog update function create
    public function update(Request $request, Post $post)
    {
        if(auth()->user()->id !== $post->user->id)
        {
            abort(403);
        }
        $request->validate([
            'title' => 'required',
            'image' => 'required | image',
            'body'  => 'required',
        ]);
        $title = $request->input('title');

        $postId = $post->id;
        $slug   = Str::slug($title,'-').'-'.$postId;
        $body   = $request->input('body');

        //File Upload
        $imagePath = 'storage/'. $request->file('image')->store('postsImage', 'public');

        $post->title = $title;
        $post->slug  = $slug;
        $post->body = $body;
        $post->imagePath = $imagePath;

        $post->save();
        return redirect()->back()->with('status','post edit successfully');
    }
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('status','Post delete successfully');
    }

}

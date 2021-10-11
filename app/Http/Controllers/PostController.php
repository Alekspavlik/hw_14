<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('posts.index', ['posts' => $posts]);
    }

    public function form()
    {
        $request = request();

        $data = [];
        $data['categories'] = Category::all();
        $data['tags'] = Tag::all();

        if ($request->method() == 'POST') {
            if(!$request->has('id')) {
                Post::create([
                    'title' => $request->get('title'),
                    'slug' => $request->get('slug'),
                    'body' => $request->get('body'),
                    'category_id' => $request->get('category'),
                ])->tags()->sync($request->get('tag'));
            } else {
                $post = Post::find($request->get('id'));
                $post->update([
                    'title' => $request->get('title'),
                    'slug' => $request->get('slug'),
                    'body' => $request->get('body'),
                    'category_id' => $request->get('category'),
                ]);
                $post->tags()->sync($request->get('tag'));
            }

            return redirect('/posts');
        }

        if (!empty($id = $request->route()->parameter('id'))) {
            $data['post'] = Post::find($id);
        }

        return view('posts.form', $data);
    }
    public function delete()
    {
        $post = Post::find(request()->route()->parameter('id'));
        $post->tags()->detach();
        $post->delete();

       return redirect('/posts');
    }
}

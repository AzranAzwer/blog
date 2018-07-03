<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index () {

        $posts = $this->getPosts();
        return view('home')->with('posts', $posts);
    }

    public function createPost (Request $request) {

        $validator = $this->validatePost($request);
        if ($validator->fails()) {
            return ['success' => false, 'data' => $validator->errors()];
        }

        $post = Post::create($request->only('title', 'description'));
        if ($post)
            return redirect()->to('home');

    }

    private function validatePost (Request $request) {
        $rules = [
            'title' => 'required',
            'description' => 'required',
        ];

        $message = [
            'title.required' => 'Title is required.',
            'description.required' => 'Description is required.',
        ];

        return $validator = Validator::make($request->only('title', 'description'), $rules, $message);
    }

    private function getPosts(){
        $posts = Post::all();
        if($posts)
            return $posts;
        return false;
    }
}

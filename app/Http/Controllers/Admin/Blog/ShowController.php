<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;


class ShowController extends Controller
{
    public function index(Blog $blog)
    {
        $blogs=Blog::all();


        return view('admin.blog.show', compact('blog'));
    }
}

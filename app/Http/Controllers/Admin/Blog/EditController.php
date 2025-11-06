<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\BlogCategory;


class EditController extends BlogRootController
{
    public function index(Blog $blog)
    {
        //$blogs=Blog::all();
        $items=BlogCategory::whereNull('parent_id')->with('childs.childs')->get();
        $fields = $this->fields;

        return view('admin.blog.edit', compact('blog', 'fields', 'items'));
    }
}

<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogCategory;


class CreateController extends BlogRootController
{
    public function index()
    {
       $fields = $this->fields;
       //dd($fields); 
        $items=BlogCategory::whereNull('parent_id')->with('childs.childs')->get();
        //$items=BlogCategory::with('parent')->get();

        return view('admin.blog.create', compact('fields', 'items'));
    }
}

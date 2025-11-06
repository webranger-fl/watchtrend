<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\UserBlogFeedback;

class DestroyController extends Controller
{
    public function index(Blog $blog)
    {
        @unlink(public_path() . "/img/blog/" . $blog->src);
        $blog->delete();
        return redirect()->route('admin.blog.index');
    }

    public function destroyFeedback(Request $req) {
      UserBlogFeedback::where(['id' => $req->id])->delete();
      return redirect()->route('admin.blog.showFeedback');
    }
}

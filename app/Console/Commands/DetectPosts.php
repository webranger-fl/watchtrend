<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Blog;

class DetectPosts extends Command
{
    protected $signature = 'app:detect-posts';

    protected $description = 'Test';

    public function handle() {
      $blogs = Blog::where(['active' => true])->with('category')->get();
      foreach($blogs as $post) {
        $relatedPosts = $post->relatedArticlesByTextAndCat($post->category->id, 6);
        if(count($relatedPosts) < 6) dd($post);
      }
    }
}

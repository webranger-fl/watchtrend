<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Blog;

class FixBlogHeaders extends Command
{
    protected $signature = 'app:fix-blog-headers';

    protected $description = '';

    public function handle()
    {
      $blogs = Blog::badHeadings()->get();
      //dd(count($blogs));
      //dd($blogs[0]->title_ru);

      foreach($blogs as $blog) {
        $text = $blog->description_ru;
        $text = preg_replace("/<h3>([^<]*)<\/h3>/", "<h2>$1</h2>", $text);
        $blog->update(['description_ru' => $text]);
        //break;
      }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seo;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Http;
//use Stevebauman\Location\Facades\Location;
use App\Helpers\Telegram;



class BlogController extends Controller
{
    public function index()
    {
      //$tg = new Telegram();
      //$tg->sendMessage(config('bot.admin_id'), 'Тестовое сообщение от бота!');
      // показать среднюю глубину просмотра с группировкой по операционным системам, работает
      /*$report = Http::ymReport()->get("/", [
        'id' => "91594683",
        'metrics' => 'ym:s:avgPageViews',
        'dimensions' => 'ym:s:operatingSystem',
        'limit' => 5
      ]);
      dd($report->json());*/
      $page='blog';
      //$blogs = config('blog.list');
      $blogcats = BlogCategory::all();
    
      //return view('blog', compact('blogs', 'blogcats'));

      // получим последние 10 опубликованных постов
      $posts = Blog::active()->latest()->with('category.parent.parent')->paginate(10);
      //dd($posts[0]->short);
      //$seo = Seo::where(['page' => $page])->first();

      return view('blog', compact(['posts', 'page', /*'seo',*/ 'blogcats']));
    }

    public function showCategory(BlogCategory $category, BlogCategory $child = null, BlogCategory $child2 = null) {
        //dd($category->childs);
        $parentCategory = $category;
        $childCategory = null;
        if($child) {
            $category = $child;
            $childCategory = $child;
        }
        if($child2) {
            $category = $child2;
            $childCategory = $child2;
        }
        $page = 'blogCategory';
        // короче тут надо собрать id вложенных категорий
        $catsIds = [];
        if(!$child && !$child2) {
            $prCategory = BlogCategory::where(['id' => $parentCategory->id])->with('childs.childs')
            ->first();
            $catsIds[] = $prCategory->id;
            foreach($prCategory->childs as $ch) {
                $catsIds[] = $ch->id;
                foreach($ch->childs as $c) $catsIds[] = $c->id;
            }
        } elseif($child && !$child2) {
            $catsIds[] = $child->id;
            foreach($child->childs as $c) $catsIds[] = $c->id;
        } elseif($child2) {
            $catsIds[] = $child2->id;
        }

        $posts = Blog::active()->latest()->whereIn('category_id', $catsIds)
        ->with('category.parent.parent')->paginate(10);
        //dd($posts);
        //dd($child);
        return view('blog.category', compact('parentCategory', 'childCategory', 'category', 'child', 'child2', 'page', 'posts'));
    }

    public function showPostFirst(BlogCategory $category, Blog $post) {
      //dd($post);
            if(!auth()->id() && !$post->active) abort(404);
            $page = 'blogpost';
            $posts = Blog::whereHas('category', function($q) use ($category, $post){
                $q->where('id', '=', $category->id);
            })->where('id', '!=', $post->id)
            ->select('id', 'thumb', 'slug', 'title', 'short_title', 'category_id')
            ->with('category.parent.parent')
            ->get();
            //dd($posts);
            $postIndex = $posts->search(function($p) use($post) {
                return $p->id === $post->id;
            });
            //$prevPost = $postIndex-1 > -1 ? $posts[$postIndex-1] : null;
            //$nextPost = $postIndex < count($posts) - 1 ? $posts[$postIndex+1] : null;
            //$blogBlock = \App\Models\Block::where(['code_name' => 'blog', 'active' => true])->first() ?? null;
            //dd($posts);
            return view('blogpost', compact(
                'category', 'post', 'page', 'posts', /*'prevPost', 'nextPost',*/
            ));
    }

    
}

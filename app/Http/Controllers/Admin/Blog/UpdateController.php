<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\IndexNow;

use App\Models\Blog;


class UpdateController extends BlogRootController
{
  /*protected $indexNow;

    public function __construct(IndexNow $indexNow)
    {
        $this->indexNow = $indexNow;
    }*/

    public function index(Request $req, Blog $blog)
    {
      $req->merge(['active' => $req->active !== 'on']);
      //$data= $req->except('search_terms', 'b64_thumb');
      $data=$req->only(array_map(function($i) { return $i['key'];}, $this->fields));
      if(request()->hasFile('thumb')){
            $file = request()->file('thumb');
            $name= Str::random(8) . "_" . $file->hashName();
            $file->move(public_path() . '/img/blog/', $name);
            //\App\Events\ImageUploaded::dispatch(public_path() . '/img/blog/', $name, [768]);
            unset($data['thumb']);
            @unlink(public_path() . "/img/blog/" . $blog->thumb);
            $data['thumb'] = $name;
      }


      $blog->update($data);

       // Логика обновления страницы
      // Получение URL обновленной страницы
      //$url = $blog->genPostUrl();
      //dd($blog->genPostUrl());

      // Отправка уведомления в IndexNow
      //if(config('app.env') === 'production') $bool = $this->indexNow->notify($url);
      //\App\Models\IndexNowRequest::create(['city' => config('app.city'), 'url' => $url, 'new' => false, 'success' => $bool ?? false]);

      //return redirect()->route('admin.blog.show', $blog->id);
      return redirect()->route('admin.blog.index');
    }

    /*public function sendWish(Request $req, Blog $blog) {
      //dd($blog);
      //dd($req->all());
      $blog->update($req->all());
      return redirect(parse_url($_SERVER['HTTP_REFERER'])['path']);
    }


    public function sendLike(Request $req, Blog $blog) {
      //$feedback = \App\Models\UserBlogFeedback::where(['ip' => request()->ip(), 'post_id' => $blog->id]);
      \App\Models\UserBlogFeedback::updateOrCreate(
        ['ip' => request()->ip(), 'post_id' => $blog->id],
        ['like' => intval($req->grade)]
    );

      return 'ok';
    }

    public function feedback(Request $req, Blog $blog) {
      \App\Models\UserBlogFeedback::updateOrCreate(
        ['ip' => request()->ip(), 'post_id' => $blog->id],
        ['like' => intval($req->grade), 'feedback' => $req->wishes]
    );

    return redirect(parse_url($_SERVER['HTTP_REFERER'])['path']);
    }*/
}

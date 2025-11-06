<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\IndexNow;

use App\Models\Blog;
use App\Http\Requests\BlogFormRequest;


class StoreController extends BlogRootController
{
  /*protected $indexNow;

    public function __construct(IndexNow $indexNow)
    {
        $this->indexNow = $indexNow;
    }*/
    // BlogFormRequest $req
    public function index(Request $req)
    {
      //dd($req->all());
      $req->merge(['active' => $req->active !== 'on']);
      if(!$req->slug && $req->title) {
        $req->merge(['slug' => translit(mb_strtolower($req->title))]);
      }
      /*$req->validate([
        'src' => 'mimes:jpg,png,jpeg',
      ]);*/
      //$data = $req->all();
      $data=$req->only(array_map(function($i) { return $i['key'];}, $this->fields));

      if($req->file('thumb')) {
        $file = $req->file('thumb');
        $name= Str::random(8) . "_" . $file->hashName();
        $file->move(public_path() . '/img/blog/', $name);
        //\App\Events\ImageUploaded::dispatch(public_path() . '/img/blog/', $name, [768]);
        unset($data['thumb']);
        $data['thumb'] = $name;
      }

        $blog = Blog::create($data);
        //$url = $blog->genPostUrl();
      //dd($blog->genPostUrl());

      // Отправка уведомления в IndexNow
      //if(config('app.env') === 'production') $bool = $this->indexNow->notify($url);
      //\App\Models\IndexNowRequest::create(['city' => config('app.city'), 'url' => $url, 'new' => true, 'success' => $bool ?? false]);


        return redirect()->route('admin.blog.index')->with('msg', 'Новая статья в блог успешно добавлена');
    }
}

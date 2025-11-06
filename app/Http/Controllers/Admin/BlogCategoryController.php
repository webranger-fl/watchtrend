<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
  public $fields;

  public function __construct()
  {
    $this->fields = [
      ['title' => 'Категория', 'key' => 'parent_id', 'type' => 'bladewind_sel', 'items' => BlogCategory::all(), 'required' => false],
      ['title' => 'Заголовок', 'key' => 'name', 'type' => 'text', 'required' => true],
      ['title' => 'URL (slug)', 'key' => 'slug', 'type' => 'text', 'required' => false],
      //['title' => 'Обложка', 'key' => 'thumb', 'type' => 'file', 'required' => false],  
      ['title' => 'Seo title', 'key' => 'seo_title', 'type' => 'seo_title', 'required' => false],
      ['title' => 'Meta desc', 'key' => 'meta_desc', 'type' => 'seo_desc', 'required' => false],
    ];
  }

    public function index()
    {
        $items=BlogCategory::with('parent')->get();

        return view('admin.blog_category.index', compact('items'));
    }

    public function create()
    {
        $items=BlogCategory::whereNull('parent_id')->with('childs.childs')->get();
        $fields = $this->fields;

        return view('admin.blog_category.create', compact('items', 'fields'));
    }

    public function store(Request $req)
    {
        if(!$req->slug) $req->merge(['slug' => translit(mb_strtolower($req->name))]);
        $data=$req->only(array_map(function($i) { return $i['key'];}, $this->fields));
        if($req->hasFile('thumb')) {
            $file = request()->file('thumb');
            $fileName = $file->hashName();
            $file->move(public_path() . '/img/blog_category/',$fileName);
            unset($data['thumb']);
            $data['thumb'] = $fileName;
        }
        BlogCategory::create($data);

        return redirect()->route('admin.blogCategory.index');
    }

    public function edit(BlogCategory $item)
    {
        $items=BlogCategory::whereNull('parent_id')
        ->whereNot('id', $item->id)
        ->with('childs.childs')->get();
        $fields = $this->fields;

        return view('admin.blog_category.edit', compact('items', 'item', 'fields'));
    }

    public function update(Request $req, BlogCategory $item)
    {
        $data=$req->only(array_map(function($i) { return $i['key'];}, $this->fields));
        if($req->hasFile('thumb')) {
            $file = request()->file('thumb');
            $fileName = $file->hashName();
            //dd($fileName);
            $file->move(public_path() . '/img/blog_category/',$fileName);
            unset($data['thumb']);
            $data['thumb'] = $fileName;
            @unlink(public_path() . "/img/blog_category/" . $item->src);
        }
      $item->update($data);

      return redirect()->route('admin.blogCategory.index');
    }

    public function destroy(BlogCategory $item)
    {
        $item->delete();
        @unlink(public_path() . "/img/blog_category/" . $item->src);
        return redirect()->route('admin.blogCategory.index');
    }
}

<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogCategory;


class BlogRootController extends Controller
{
  public $fields;

  public function __construct()
  {
    $this->fields = [
      //['title' => 'Категория', 'key' => 'category_id', 'type' => 'number', 'required' => true],
      ['title' => 'Категория', 'key' => 'category_id', 'type' => 'bladewind_sel', 'items' => BlogCategory::all(), 'required' => true],
      ['title' => 'Заголовок', 'key' => 'title', 'type' => 'text', 'required' => true],
      ['title' => 'Вводный текст', 'key' => 'headline', 'type' => 'text', 'required' => false],
      ['title' => 'URL (slug)', 'key' => 'slug', 'type' => 'text', 'required' => false],
      ['title' => 'Обложка', 'key' => 'thumb', 'type' => 'file', 'required' => false],
      ['title' => 'Контент', 'key' => 'content', 'type' => 'summernote', 'required' => true],
      ['title' => 'Seo title', 'key' => 'seo_title', 'type' => 'text', 'required' => false],
      ['title' => 'Meta desc', 'key' => 'meta_desc', 'type' => 'text', 'required' => false],
      ['title' => 'Short title', 'key' => 'short_title', 'type' => 'text', 'required' => false],
      ['title' => 'Опубликовать?', 'key' => 'active', 'type' => 'checkbox', 'required' => false],
    ];
  }
}

<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogCategory;


class FieldsController extends Controller
{
  public $fields;

  // переделывать будет не просто
    public function __construct()
    {
      $this->fields = [
        ['title' => 'Название, ru', 'key' => 'title_ru', 'type' => 'text', 'required' => true],
        ['title' => 'Название, kz', 'key' => 'title_kz', 'type' => 'text', 'required' => false],
        //['title' => 'URL (укажите сами или сгенерируется автоматически из названия)', 'key' => 'url', 'type' => 'text', 'required' => false],
      ];
    }
}

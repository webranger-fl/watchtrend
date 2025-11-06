<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Link;

class LinksController extends Controller
{
  public $fields;

  public function __construct()
  {
    $this->fields = [
      ['title' => 'Название', 'key' => 'name', 'type' => 'text', 'required' => true],
      ['title' => 'URL', 'key' => 'url', 'type' => 'text', 'required' => true],
    ];
  }

    public function index()
    {
        $items = Link::all();

        return view('admin.link.index', compact('items'));
    }

    public function create()
    {
      $fields = $this->fields;
        return view('admin.link.create', compact('fields'));
    }

    public function store(Request $req)
    {
      if(!$req->url) $req->merge(['url' => mb_strtolower(translit($req->name))]);
      Link::create($req->all());

      return redirect()->route('admin.links.index');
    }

    public function edit(Link $link)
    {
      $fields = $this->fields;
        return view('admin.link.edit', compact('link', 'fields'));
    }

    public function update(Request $req, Link $link)
    {
      if(!$req->url) $req->merge(['url' => mb_strtolower(translit($req->name))]);
      $link->update($req->all());

      return redirect()->route('admin.links.index');
    }

    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('admin.links.index');
    }
}

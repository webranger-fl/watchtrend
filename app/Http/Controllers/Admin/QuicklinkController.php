<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Quicklink;

class QuicklinkController extends Controller
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
        $items = Quicklink::all();

        return view('admin.quicklink.index', compact('items'));
    }

    public function create()
    {
      $fields = $this->fields;
        return view('admin.quicklink.create', compact('fields'));
    }

    public function store(Request $req)
    {
      Quicklink::create($req->all());

      return redirect()->route('admin.quicklink.index');
    }

    public function edit(Quicklink $quicklink)
    {
      $fields = $this->fields;
        return view('admin.quicklink.edit', compact('quicklink', 'fields'));
    }

    public function update(Request $req, Quicklink $quicklink)
    {
      $quicklink->update($req->all());

      return redirect()->route('admin.quicklink.index');
    }

    public function destroy(Quicklink $quicklink)
    {
        $quicklink->delete();
        return redirect()->route('admin.quicklink.index');
    }
}

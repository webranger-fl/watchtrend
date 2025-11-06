<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TgContact;

class TgContactController extends Controller
{
  public $fields;

  public function __construct()
  {
    $this->fields = [
      ['title' => 'ID в телеграме', 'key' => 'tg_id', 'type' => 'text', 'required' => true],
      ['title' => 'Имя', 'key' => 'name', 'type' => 'text', 'required' => true],
      ['title' => 'Телефон (необязательно)', 'key' => 'phone', 'type' => 'text', 'required' => false],
      ['title' => 'Коммент (необязательно)', 'key' => 'comment', 'type' => 'text', 'required' => false],
    ];
  }

    public function index()
    {
        $items = TgContact::all();

        return view('admin.tgcontact.index', compact('items'));
    }

    public function create()
    {
      $fields = $this->fields;
        return view('admin.tgcontact.create', compact('fields'));
    }

    public function store(Request $req)
    {
      TgContact::create($req->all());

      return redirect()->route('admin.tgcontact.index');
    }

    public function edit(TgContact $tg)
    {
      $fields = $this->fields;
        return view('admin.tgcontact.edit', compact('tg', 'fields'));
    }

    public function update(Request $req, TgContact $tg)
    {
      $tg->update($req->all());

      return redirect()->route('admin.tgcontact.index');
    }

    public function destroy(TgContact $pc)
    {
        $pc->delete();
        return redirect()->route('admin.tgcontact.index');
    }
}

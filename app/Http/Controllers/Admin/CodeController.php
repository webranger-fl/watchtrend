<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Code;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

use App\Helpers\ControllerGenerator;
use App\Helpers\ViewGenerator;

class CodeController extends Controller
{

    public function index()
    {
      $code = Code::first();
      $fields = [
        ['title' => 'Код в конце head', 'key' => 'head', 'type' => 'vscode', 'required' => false, 'hint' => 'этот код будет вставлен в конец head'],
        ['title' => 'Код в конце body', 'key' => 'body', 'type' => 'vscode', 'required' => false,],
      ];

      return view('admin.code.edit', compact('fields', 'code'));
    }

    public function update(Request $req) {
      //dd($req->all());
      $code = Code::first();
      $code->update($req->all());
      return ['ok'];
      return redirect()->route('admin.code.index')->with('msg', "Коды сохранены");
    }

}

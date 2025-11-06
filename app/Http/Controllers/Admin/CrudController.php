<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SiteRequest;
use App\Models\PerfRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

use App\Helpers\ControllerGenerator;
use App\Helpers\ViewGenerator;

class CrudController extends Controller
{

    public function index()
    {
      $fields = [
        ['title' => 'Название ресурса', 'key' => 'resource_name', 'type' => 'text', 'required' => true, 'hint' => 'с маленькой буквы'],
        ['title' => 'Создать файлы модели и миграции?', 'key' => 'create_model', 'type' => 'checkbox', 'required' => false,],
        //['title' => 'Название контроллера', 'key' => 'controller_name', 'type' => 'text', 'required' => true, 'hint' => 'без Controller'],
        //['title' => 'Префикс для роутов', 'key' => 'prefix', 'type' => 'text', 'required' => true, 'hint' => 'без /'],
        //['title' => 'Папка для видов', 'key' => 'view_folder', 'type' => 'text', 'required' => true],
      ];

      return view('admin.crud.create', compact('fields'));
    }

    public function store(Request $req) {
      //dd($req->all());
      $req->merge(['create_model' => $req->create_model === 'on']);
      $model = ucfirst($req->resource_name);

      ControllerGenerator::generateController($req->resource_name);
      ViewGenerator::generateView($req->resource_name);
      if($req->create_model) {
        Artisan::call("make:model -m $model");
      }
      //dd(1);

      $msg = "Контроллер и папка с видами сгенерированы для ресурса $model.";
      if($req->create_model) $msg .= " + создана модель и миграция";

      return redirect()->route('admin.crud')->with('msg', $msg);
    }

}

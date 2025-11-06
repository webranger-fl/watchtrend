<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SiteRequest;
use App\Models\PerfRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MetrikaController extends Controller
{

    public function index()
    {
      // https://yandex.ru/dev/metrika/ru/stat/examples
      // формирует отчет по количеству визитов и уникальных посетителей, перешедших из поисковых систем
      // непонятно
      /*$report = Http::ymReport()->get("/", [
        'id' => "91594683",
        'metrics' => 'ym:s:users',
        'dimensions' => 'ym:s:searchEngineName',
        'filters' => "ym:s:trafficSourceName=='Переходы из поисковых систем'",
        'limit' => 10
      ]);*/

      // посещаемость, группировка по дням, работает
      /*$report = Http::ymReport()->get("/", [
        'id' => "91594683",
        "preset" => "traffic",
        'metrics' => 'ym:s:users',
        'dimensions' => 'ym:s:datePeriod<group>',
        'group' => 'day',
        //'filters' => "ym:s:trafficSourceName=='Переходы из поисковых систем'",
        'limit' => 10
      ]);*/
      //dd($report->json());
      $base = 'https://metrika.yandex.ru/stat';
      return view('admin.metrika.index', compact('base'));
    }

}

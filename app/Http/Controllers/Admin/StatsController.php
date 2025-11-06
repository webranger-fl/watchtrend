<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SiteRequest;
use App\Models\PerfRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{

    public function perf()
    {
      $count = [];

      $count['all'] = PerfRequest::filtered()->lastMonth()->count();
      $count['all_avg'] = round(PerfRequest::filtered()->lastMonth()->avg('execution_time'), 2);

      $count['today'] = PerfRequest::filtered()->today()->count();
      $count['today_cache'] = PerfRequest::filtered()->today()->where(['cache_hit' => true])->count();
      $count['today_avg'] = round(PerfRequest::filtered()->today()->avg('execution_time'), 2);

      $count['week'] = PerfRequest::filtered()->lastSevenDays()->count();
      $count['week_avg'] = round(PerfRequest::filtered()->lastSevenDays()->avg('execution_time'), 2);

      $todayByHour = PerfRequest::filtered()->today()
      //->select(DB::raw('HOUR(created_at) as hour, COUNT(*) as count'))
      ->select(DB::raw('HOUR(created_at) as hour, AVG(execution_time) as avg'))
         ->groupBy(DB::raw('HOUR(created_at)'))
         ->get();

      $stats = [];

         $stats['slowReqsByHour'] = PerfRequest::filtered()->today()
        ->select(DB::raw('HOUR(created_at) as hour, COUNT(*) as count'))
        ->where('execution_time', '>', 0.5)
         ->groupBy(DB::raw('HOUR(created_at)'))
         ->get();
      
      //dd($stats['slowReqsByHour']);
      $stats['slowReqs'] = PerfRequest::filtered()->today()->where('execution_time', '>', 0.5)->orderByDesc('id')->paginate(20);
      $stats['slowReqsCount'] = PerfRequest::filtered()->today()->where('execution_time', '>', 0.5)->count();

      $stats['slowReqsPercentToday'] = 0;

      if($count['today'] > 0) $stats['slowReqsPercentToday'] = round(($stats['slowReqsCount'] / $count['today']) * 100, 2);


      $reqs = PerfRequest::filtered()->latest()->paginate(20);

      return view('admin.stats.perf', compact('count', 'reqs', 'todayByHour', 'stats'));
    }

}

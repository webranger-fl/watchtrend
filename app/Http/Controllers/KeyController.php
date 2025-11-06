<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seo;
use App\Models\WordstatPhrase;
use App\Models\WordstatPhraseStat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
//use Stevebauman\Location\Facades\Location;
use App\Helpers\Telegram;

class KeyController extends Controller
{
    public function index(Request $req)
    {
      //dd($req->slug);
      $key = WordstatPhrase::where(['slug' => $req->slug])->with('stats')->with('stat')->first();
      if(!$key) abort(404);
      //dd($key->stats);
      $firstMonthStat = $key->stats[0];
      $lastMonthStat = $key->stats[count($key->stats) - 1];
      //dd($lastMonthStat);
      $firstMonth = ruMonthFull2(strtotime($firstMonthStat->date)) . " " . date('Y', strtotime($firstMonthStat->date));
      $lastMonth = ruMonthFull2(strtotime($lastMonthStat->date)) . " " . date('Y', strtotime($lastMonthStat->date));
      $monthCount = floor((strtotime($lastMonthStat->date) - strtotime($firstMonthStat->date)) / (86400 * 30));
      //dd($monthCount);
      $hasDevicesStats = false;
      if($key->stat && $key->stat->desktop) $hasDevicesStats = true;

      $stats = [];
      foreach($key->stats as $stat) {
        $date = mb_ucfirst(ruMonth(strtotime($stat->date))) . " " . date('Y', strtotime($stat->date));
        $date2 = mb_ucfirst(ruMonth(strtotime($stat->date))) . " " . date('y', strtotime($stat->date));
        //dd($date2);
        $stats[] = ['month' => $date, 'shortMonth' => $date2, 'value' => $stat->value];
      }
      //dd($stats);
      $addStats = $key->calcStats();
      //dd($key->lastStat);
      //dd(date('Y-m-01', strtotime('-2 month')));
      // периоды роста нужно найти, топ 3. и спада
      $ups = WordstatPhraseStat::where(['phrase_id' => $key->id])->where('percent_change', '>', 0)->orderByDesc('percent_change')/*->limit(3)*/->get();
      $downs = WordstatPhraseStat::where(['phrase_id' => $key->id])->where('percent_change', '<', 0)->orderBy('percent_change')/*->limit(3)*/->get();
      foreach($ups as $u) $u->date2 = ruMonthFull2(strtotime($u->date)) . " " . date('Y', strtotime($u->date));
      foreach($downs as $u) $u->date2 = ruMonthFull2(strtotime($u->date)) . " " . date('Y', strtotime($u->date));
      //dd($ups);
      // вычислить кол-во отрезков спада и роста, лучше в calcStats

      return view('key', compact('key', 'stats', 'firstMonth', 'lastMonth', 'monthCount', 'addStats', 'hasDevicesStats', 'lastMonthStat', 'ups', 'downs'));
    }

    public function data(Request $req)
    {
      $key = WordstatPhrase::where(['slug' => $req->slug])->with('stats')->with('stat')->first();

      $stats = [];
      foreach($key->stats as $stat) {
        $date = mb_ucfirst(ruMonth(strtotime($stat->date))) . " " . date('Y', strtotime($stat->date));
        $date2 = mb_ucfirst(ruMonth(strtotime($stat->date))) . " " . date('y', strtotime($stat->date));
        $stats[] = ['month' => $date, 'shortMonth' => $date2, 'value' => $stat->value];
      }
      return compact('stats');
    }


    
}

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

class HomeController extends Controller
{
    public function index()
    {
      // нужно взять только топовые, топ10
      //$trends = WordstatPhrase::limit(20)->get();
      //$trends = WordstatPhraseStat::distinct('phrase_id')->orderByDesc('value')->with('phrase')->limit(10)->get();
      $trends = WordstatPhrase::withMax('stats', 'value')
      ->orderByDesc('stats_max_value') 
      ->limit(10)
      ->get();
      //dd($trends);
      return view('home', compact('trends'));
    }

    function analyze(Request $req) {
      if(session()->has("guest_request_limit_analyze")) {
         return redirect()->route('home', ['limit' => 1]);
      }
      //dd(session()->has("guest_request_limit_analyze"));
      /*if(session()->has("guest_analyze_requests") && intval(session()->get("guest_analyze_requests")) >= 3) {
         return redirect()->route('home', ['limit' => 1]);
      }*/

      $req->validate([
        'keyword' => 'required|min:2|max:30'
      ]);

      //dd($req->keyword);
      $keyword = $req->keyword;
      $slug = translit($keyword);

      $key = WordstatPhrase::where(['phrase' => $keyword])->first();
      // пока редиректим, позже можно обновлять стату динамики
      if($key) {
        //dd('exist');
        return redirect()->route('key', ['slug' => $slug]);
      }

      DB::transaction(function () use ($keyword) {
        //global $slug;
        $phrase = WordstatPhrase::create(['phrase' => $keyword, 'slug' => translit($keyword)]);
        $slug = $phrase->slug;
        // захватываем больше месяцев
        $fromDate = date('Y-m-d', time() - 86400 * 500);
        //$fromDate = date('Y-m-d', time() - 86400 * 365);
        //$fromDate = date('Y-m-d', time() - 86400 * 400);
        // получаем первое число месяца
        $fromDate = preg_replace("/[0-9]{2}$/", "01", $fromDate);
        //dd($fromDate);

        $req = Http::wordstatAPI()->post("/dynamics", [
          'phrase' => $keyword,
          'period' => 'monthly',
          // ровно год назад
          'fromDate' => $fromDate,
          //'toDate' => date('Y-m-d'),
          // пока без regions, devices
        ]);

        $body = json_decode($req->body());
        //dd($body);
        // тут конечно нужны проверки чтобы не добавлять повторные записи если уже есть + сразу вычисление процента изменения
        foreach($body->dynamics as $idx => $d) {
          $stat = WordstatPhraseStat::where(['phrase_id' => $phrase->id,'date' => $d->date,'type' => 'monthly'])->first();
          if($stat) continue;
          WordstatPhraseStat::create([
            'phrase_id' => $phrase->id,
            'date' => $d->date,
            'value' => $d->count,
            'type' => 'monthly',
            //'percent_change' => $idx === 0 ? null : round((($d->count - $body->dynamics[$idx-1]->count) / ($body->dynamics[$idx-1]->count)) * 100)
            'percent_change' => $idx === 0 ? null : calcPercentChange($d, $body->dynamics[$idx-1])
          ]);
        }
        if (auth()->guest()) {
          if(!session()->has("guest_analyze_requests")) session()->put("guest_analyze_requests", 1);
          else {
            session()->put("guest_analyze_requests", intval(session()->get("guest_analyze_requests")) + 1);
            if(intval(session()->get("guest_analyze_requests")) > 2) session()->put("guest_request_limit_analyze", true);
          }
          //session()->put("guest_request_limit_analyze", true);
        }
        //return redirect()->route('key', ['slug' => $slug]);
      });

      return redirect()->route('key', ['slug' => $slug]);
    }

    function devices(Request $req) {
      $slug = $req->slug;
      $key = WordstatPhrase::where(['slug' => $slug])->with('stat')->first();
      if($key->stat && $key->stat->desktop) {
         return redirect()->route('key', ['slug' => $slug]);
      }
      // тут уходит 3 запроса чтобы собрать все данные
      \App\Jobs\FetchDevicesData::dispatch($key);
      return redirect()->route('key', ['slug' => $slug])->with('msg', 'Данные по устройствам скоро отобразятся. Обновите страницу через 5-10 секунд.');


      /*$fromDate = date('Y-m-d', time() - 86400 * 365);
      $fromDate = preg_replace("/[0-9]{2}$/", "01", $fromDate);
      dd($key->stat->date);*/

      foreach(['desktop', 'tablet', 'phone'] as $device) {
        $req = Http::wordstatAPI()->post("/dynamics", [
        'phrase' => $key->phrase,
        'period' => 'monthly',
        //'fromDate' => $fromDate,
        'fromDate' => $key->stat->date,
        'devices' => [$device]
        ]);

        $body = json_decode($req->body());

        foreach($body->dynamics as $d) {
          $stat = WordstatPhraseStat::where(['phrase_id' => $key->id, 'date' => $d->date])->first();
          if(!$stat) continue;
          $stat->update([$device => $d->count]);
        }
        //dump($device);
      }

    }

    
}

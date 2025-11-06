<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WordstatPhrase;
use App\Models\WordstatPhraseStat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class WordstatPhraseController extends Controller
{
  public $fields;

  public function __construct()
  {
    $this->fields = [
      ['title' => 'Фраза', 'key' => 'phrase', 'type' => 'text', 'required' => true],
    ];
  }

    public function index()
    {
        $items = WordstatPhrase::with('stats')->orderByDesc('id')->paginate(20);
        //dd($items[0]);

        return view('admin.wordstatPhrase.index', compact('items'));
    }

    public function create()
    {
      $fields = $this->fields;
        return view('admin.wordstatPhrase.create', compact('fields'));
    }

    public function store(Request $req) {
      DB::transaction(function () use ($req) {
        $phrase = WordstatPhrase::create($req->all());
      // тут будет запрос к API
      $fromDate = date('Y-m-d', time() - 86400 * 365);
      // получаем первое число месяца
      $fromDate = preg_replace("/[0-9]{2}$/", "01", $fromDate);
      //dd($fromDate);

      $req = Http::wordstatAPI()->post("/v1/dynamics", [
        'phrase' => $req->phrase,
        'period' => 'monthly',
        // ровно год назад
        'fromDate' => $fromDate,
        //'toDate' => date('Y-m-d'),
        // пока без regions, devices
      ]);

      $body = json_decode($req->body());
      // тут конечно нужны проверки чтобы не добавлять повторные записи если уже есть
      foreach($body->dynamics as $d) {
        WordstatPhraseStat::create([
          'phrase_id' => $phrase->id,
          'date' => $d->date,
          'value' => $d->count,
          'type' => 'monthly',
        ]);
      }
      });     


      return redirect()->route('admin.wordstatPhrase.index');
    }

     public function getDevicesData(WordstatPhrase $wordstatPhrase) {
      //dd($wordstatPhrase);
      $fromDate = date('Y-m-d', time() - 86400 * 365);
      $fromDate = preg_replace("/[0-9]{2}$/", "01", $fromDate);

      foreach(['desktop', 'tablet', 'phone'] as $device) {
        $req = Http::wordstatAPI()->post("/v1/dynamics", [
        'phrase' => $wordstatPhrase->phrase,
        'period' => 'monthly',
        'fromDate' => $fromDate,
        'devices' => [$device]
        ]);

        $body = json_decode($req->body());

        foreach($body->dynamics as $d) {
          $stat = WordstatPhraseStat::where(['phrase_id' => $wordstatPhrase->id, 'date' => $d->date])->first();
          if(!$stat) continue;
          $stat->update([$device => $d->count]);
        }
        dump($device);
      }
      return redirect()->route('admin.wordstatPhrase.index');
     }

    public function edit(WordstatPhrase $wordstatPhrase)
    {
      $fields = $this->fields;
        return view('admin.wordstatPhrase.edit', compact('wordstatPhrase', 'fields'));
    }

    public function show(WordstatPhrase $wordstatPhrase)
    {
      $labels = [];
      $data = [];
      foreach($wordstatPhrase->stats as $s) {
        $labels[] = $s->date;
        $data[] = $s->count;
      }
      // лучше бы здесь названия месяцев типа сентябрь 2025
      //dd($labels);
      // посчитать общее кол-во запросов по устройствам
      $stats = [];
      //$statsQuery = WordstatPhraseStat::where(['phrase_id' => $wordstatPhrase->id, 'type' => 'monthly']);
      if($wordstatPhrase->stat->desktop) {
        $stats['all'] = WordstatPhraseStat::where(['phrase_id' => $wordstatPhrase->id, 'type' => 'monthly'])->sum('value');
        $stats['desktop'] = WordstatPhraseStat::where(['phrase_id' => $wordstatPhrase->id, 'type' => 'monthly'])->sum('desktop');
        $stats['tablet'] = WordstatPhraseStat::where(['phrase_id' => $wordstatPhrase->id, 'type' => 'monthly'])->sum('tablet');
        $stats['phone'] = WordstatPhraseStat::where(['phrase_id' => $wordstatPhrase->id, 'type' => 'monthly'])->sum('phone');
        $stats['desktop_percent'] = round(($stats['desktop'] / $stats['all']) * 100);
        $stats['tablet_percent'] = round(($stats['tablet'] / $stats['all']) * 100);
        $stats['phone_percent'] = round(($stats['phone'] / $stats['all']) * 100);
      }
      //dd($stats);
      
      return view('admin.wordstatPhrase.show', compact('wordstatPhrase', 'labels', 'data', 'stats'));
    }

    public function update(Request $req, WordstatPhrase $wordstatPhrase)
    {
      $wordstatPhrase->update($req->all());

      return redirect()->route('admin.wordstatPhrase.index');
    }

    public function destroy(WordstatPhrase $wordstatPhrase)
    {
      //dd($wordstatPhrase);
      WordstatPhraseStat::where(['phrase_id' => $wordstatPhrase->id])->delete();
        $wordstatPhrase->delete();
        return redirect()->route('admin.wordstatPhrase.index');
    }
}

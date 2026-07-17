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
      $key = WordstatPhrase::where(['slug' => $req->slug])->with('stat')->with('stats')->first();
      if(!$key) abort(404);
      //$key->setRelation('stats', $key->stats()->orderBy('date')->limit(18)->get());
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

      $monthsBehind = (int)date('Y') * 12 + (int)date('n') - ((int)date('Y', strtotime($lastMonthStat->date)) * 12 + (int)date('n', strtotime($lastMonthStat->date)));
      $showUpdate = $monthsBehind >= 3;

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

      return view('key', compact('key', 'stats', 'firstMonth', 'lastMonth', 'monthCount', 'addStats', 'hasDevicesStats', 'lastMonthStat', 'ups', 'downs', 'showUpdate'));
    }

    public function update(Request $req)
    {
      $key = WordstatPhrase::where(['slug' => $req->slug])->with('stats')->first();
      if(!$key) abort(404);

      $lastMonthStat = $key->stats->sortBy('date')->last();
      if(!$lastMonthStat) return redirect()->route('key', ['slug' => $key->slug]);

      $monthsBehind = (int)date('Y') * 12 + (int)date('n') - ((int)date('Y', strtotime($lastMonthStat->date)) * 12 + (int)date('n', strtotime($lastMonthStat->date)));
      if($monthsBehind < 3) {
        return redirect()->route('key', ['slug' => $key->slug])->with('msg', 'Обновление пока не требуется.');
      }

      $fromDate = date('Y-m-01\T12:34:56+03:00', strtotime($lastMonthStat->date));

      \App\Jobs\FetchPhraseData::dispatch($key, $fromDate);

      return redirect()->route('key', ['slug' => $key->slug])->with('msg', 'Данные обновляются. Обновите страницу через 5-10 секунд.');
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

    public function analyze(Request $req)
    {
      $key = WordstatPhrase::where(['slug' => $req->slug])->with('stats')->first();
      if(!$key) abort(404);

      $key->load('stats');
      $stats = $key->stats->sortBy('date')->values();

      $lines = '';
      foreach($stats as $s) {
        $lines .= date('Y-m', strtotime($s->date)) . ': ' . (int)$s->value . "\n";
      }
      $dynamics = trim($lines);

      $systemPrompt = "Ты аналитик трендов поисковых запросов. Тебе дана динамика количества поисковых запросов по месяцам. Проанализируй данные: выдели общий тренд (рост/спад/стабильность), отметь пики и спады, укажи возможные причины сезонности если они видны. Дай понятное человеческим языком текстовое описание тренда на русском языке, объемом 4-7 предложений. Без markdown-разметки, без заголовков, без списков — только связный текст.";

      $userPrompt = "Фраза: \"" . $key->phrase . "\"\n\nДинамика запросов по месяцам:\n" . $dynamics;

      $response = Http::polza()->post('', [
        'model' => 'deepseek/deepseek-v4-flash',
        'messages' => [
          ['role' => 'system', 'content' => $systemPrompt],
          ['role' => 'user', 'content' => $userPrompt],
        ],
        'temperature' => 0.4,
      ]);

      if(!$response->successful()) {
        return redirect()->route('key', ['slug' => $key->slug])->with('msg', 'Не удалось получить ИИ-анализ: ошибка API (' . $response->status() . ').');
      }

      $body = $response->json();
      $text = $body['choices'][0]['message']['content'] ?? null;
      if(!$text) {
        return redirect()->route('key', ['slug' => $key->slug])->with('msg', 'Не удалось получить ИИ-анализ: пустой ответ.');
      }

      $key->ai_analysis = trim($text);
      $key->ai_analyzed_at = now();
      $key->save();

      return redirect()->route('key', ['slug' => $key->slug])->with('msg', 'ИИ-анализ тренда успешно получен.');
    }
}

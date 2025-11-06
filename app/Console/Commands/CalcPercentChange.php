<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WordstatPhrase;
use App\Models\WordstatPhraseStat;

class CalcPercentChange extends Command
{

    protected $signature = 'app:calc-percent-change';

    protected $description = '';

    public function handle()
    {
      $keys = WordstatPhrase::with('stats')->get();

      foreach($keys as $k) {
        foreach($k->stats as $stat) {
          // пропускаем если percent_change есть
          if($stat->percent_change) continue;
          $prevStat = WordstatPhraseStat::where(['phrase_id' => $k->id])->where('id', '<', $stat->id)->orderByDesc('id')->first();
          if(!$prevStat) continue;
          $prevStatValue = $prevStat->value;
          $statValue = $stat->value;
          //dd($prevStat);
          $changePercent = round((($statValue - $prevStatValue) / $prevStatValue) * 100);
          $stat->update(['percent_change' => $changePercent]);
        }
        $this->comment("Phrase $k->phrase is done");
      }
    }
}

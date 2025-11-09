<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Support\Facades\Http;
use App\Models\WordstatPhraseStat;

class FetchPhraseData implements ShouldQueue
{
    use Queueable;

    public $phrase;

    public function __construct($phrase)
    {
       $this->phrase = $phrase;
    }

    public function handle(): void
    {
      $fromDate = date('Y-m-d', time() - 86400 * 365);
      $fromDate = preg_replace("/[0-9]{2}$/", "01", $fromDate);

       $req = Http::wordstatAPI()->post("/v1/dynamics", [
          'phrase' => $this->phrase->phrase,
          'period' => 'monthly',
          'fromDate' => $fromDate,
        ]);

         $body = json_decode($req->body());

        foreach($body->dynamics as $idx => $d) {
          $stat = WordstatPhraseStat::where(['phrase_id' => $this->phrase->id,'date' => $d->date,'type' => 'monthly'])->first();
          if($stat) continue;
          WordstatPhraseStat::create([
            'phrase_id' => $this->phrase->id,
            'date' => $d->date,
            'value' => $d->count,
            'type' => 'monthly',
            //'percent_change' => $idx === 0 ? null : round((($d->count - $body->dynamics[$idx-1]->count) / ($body->dynamics[$idx-1]->count)) * 100)
            'percent_change' => $idx === 0 ? null : $this->calcPercentChange($d, $body->dynamics[$idx-1])
          ]);
        }
      
    }

    public function calcPercentChange($stat, $prevStat) {
      if($stat->count === 0 && $prevStat->count === 0) return 0;
      if($prevStat->count === 0) return 100;
      return round((($stat->count - $prevStat->count) / ($prevStat->count)) * 100);
    }

}

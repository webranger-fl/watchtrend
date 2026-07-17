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
    public $fromDate;

    public function __construct($phrase, $fromDate = null)
    {
       $this->phrase = $phrase;
       $this->fromDate = $fromDate;
    }

    public function handle(): void
    {
      if($this->fromDate) {
        $fromDate = $this->fromDate;
      } else {
        $fromDate = date('Y-m-d', time() - 86400 * 365);
        $fromDate = preg_replace("/[0-9]{2}$/", "01", $fromDate);
      }
      //dd($fromDate);

       $req = Http::wordstatAPI()->post("/dynamics", [
          'phrase' => $this->phrase->phrase,
          'period' => 'PERIOD_MONTHLY',
          'fromDate' => $fromDate,
          'folderId' => 'b1g1gli0dfev7nrvm0bs',
        ]);

         $body = json_decode($req->body());
         //dd($body);

        foreach($body->results as $idx => $d) {
          $stat = WordstatPhraseStat::where(['phrase_id' => $this->phrase->id,'date' => $d->date,'type' => 'monthly'])->first();
          if($stat) continue;
          WordstatPhraseStat::create([
            'phrase_id' => $this->phrase->id,
            'date' => $d->date,
            'value' => $d->count,
            'type' => 'monthly',
            //'percent_change' => $idx === 0 ? null : round((($d->count - $body->results[$idx-1]->count) / ($body->results[$idx-1]->count)) * 100)
            'percent_change' => $idx === 0 ? null : $this->calcPercentChange($d, $body->results[$idx-1])
          ]);
        }
      
    }

    public function calcPercentChange($stat, $prevStat) {
      if($stat->count === 0 && $prevStat->count === 0) return 0;
      if($prevStat->count === 0) return 100;
      return round((($stat->count - $prevStat->count) / ($prevStat->count)) * 100);
    }

}

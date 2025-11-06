<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Support\Facades\Http;
use App\Models\WordstatPhraseStat;

class FetchDevicesData implements ShouldQueue
{
    use Queueable;

    public $key;

    /**
     * Create a new job instance.
     */
    public function __construct($key)
    {
       $this->key = $key;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach(['desktop', 'tablet', 'phone'] as $device) {
        $req = Http::wordstatAPI()->post("/v1/dynamics", [
        'phrase' => $this->key->phrase,
        'period' => 'monthly',
        //'fromDate' => $fromDate,
        'fromDate' => $this->key->stat->date,
        'devices' => [$device]
        ]);

        $body = json_decode($req->body());

        foreach($body->dynamics as $d) {
          $stat = WordstatPhraseStat::where(['phrase_id' => $this->key->id, 'date' => $d->date])->first();
          if(!$stat) continue;
          $stat->update([$device => $d->count]);
        }
        //dump($device);
      }
    }
}

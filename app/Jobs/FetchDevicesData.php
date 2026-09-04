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
        foreach([
          'desktop' => 'DEVICE_DESKTOP',
          'tablet' => 'DEVICE_TABLET',
          'phone' => 'DEVICE_PHONE',
        ] as $device => $deviceType) {
        $req = Http::wordstatAPI()->post("/dynamics", [
        'phrase' => $this->key->phrase,
        'period' => 'PERIOD_MONTHLY',
        //'fromDate' => $fromDate,
        'fromDate' => $this->key->stat->date,
        'folderId' => 'b1g1gli0dfev7nrvm0bs',
        'devices' => [$deviceType]
        ]);

        $body = json_decode($req->body());

        foreach($body->results as $d) {
          $stat = WordstatPhraseStat::where(['phrase_id' => $this->key->id, 'date' => $d->date])->first();
          if(!$stat) continue;
          $stat->update([$device => $d->count]);
        }
        //dump($device);
      }
    }
}

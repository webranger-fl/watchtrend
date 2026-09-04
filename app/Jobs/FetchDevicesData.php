<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\WordstatPhraseStat;
use Carbon\Carbon;

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
        $this->key->loadMissing('stat');

        if (!$this->key->stat) {
            throw new \RuntimeException('No monthly statistics found for phrase ' . $this->key->id);
        }

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
        $req->throw();

        $body = $req->json();
        if (!isset($body['results']) || !is_array($body['results'])) {
          throw new \UnexpectedValueException('Wordstat API response does not contain results');
        }

        $updated = 0;
        foreach($body['results'] as $d) {
          $date = $d['date'];
          $calendarDate = Carbon::parse($date)->format('Y-m-d');
          $stat = WordstatPhraseStat::where('phrase_id', $this->key->id)
            ->where('type', 'monthly')
            ->where(function ($query) use ($date, $calendarDate) {
              $query->where('date', $date)->orWhere('date', $calendarDate);
            })
            ->first();
          if(!$stat) continue;
          $stat->update([$device => $d['count']]);
          $updated++;
        }
        Log::info('Device statistics fetched', [
          'phrase_id' => $this->key->id,
          'device' => $device,
          'results' => count($body['results']),
          'updated' => $updated,
        ]);
      }
    }
}

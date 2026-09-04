<?php

use App\Models\WordstatPhrase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/_local/devices/{slug:slug}/{device?}', function (string $slug, ?string $device = null) {
    $key = WordstatPhrase::where('slug', $slug)->with('stat')->firstOrFail();

    $devices = [
        'desktop' => 'DEVICE_DESKTOP',
        'tablet' => 'DEVICE_TABLET',
        'phone' => 'DEVICE_PHONE',
    ];
    $deviceType = $devices[$device ?? 'desktop'] ?? $device;

    $payload = [
        'phrase' => $key->phrase,
        'period' => 'PERIOD_MONTHLY',
        'fromDate' => $key->stat->date,
        'folderId' => 'b1g1gli0dfev7nrvm0bs',
        'devices' => [$deviceType],
    ];
    $response = Http::wordstatAPI()->post('/dynamics', $payload);

    dd([
        'payload' => $payload,
        'status' => $response->status(),
        'headers' => $response->headers(),
        'body' => $response->body(),
        'json' => $response->json(),
    ]);
})->name('local.devices');

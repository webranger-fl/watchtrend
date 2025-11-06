<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PerfRequest;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        PerfRequest::factory(1000)
        /*->state(new Sequence(
          fn (Sequence $sequence) => 
            ['created_at' => "2024-12-31 18:07:24"]
          
        ))*/
        ->state(function (array $attributes/*, PerfRequest $perfRequest*/) {
          //$day = mt_rand(1, 31);
          $day = 1;
          $h = mt_rand(0, 23);
          $m = mt_rand(0, 60);
          $s = mt_rand(0, 60);
          if($h < 10) $h = "0" . strval($h);
          if($m < 10) $m = "0" . strval($m);
          if($s < 10) $s = "0" . strval($s);

          return ['created_at' => "2025-01-$day $h:$m:$s", 'updated_at' => "2025-01-$day $h:$m:$s"];
        })
        ->create();
    }
}

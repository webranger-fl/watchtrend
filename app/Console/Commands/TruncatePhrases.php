<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Blog;
use Illuminate\Support\Facades\DB;

class TruncatePhrases extends Command
{
    protected $signature = 'app:truncate-phrases';

    protected $description = 'Test';

    public function handle() {
      DB::table('wordstat_phrases')->truncate();
      DB::table('wordstat_phrase_stats')->truncate();
    }
}

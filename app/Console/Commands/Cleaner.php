<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Cleaner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleaner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      //\App\Models\PerfRequest::whereRaw('UNIX_TIMESTAMP() - UNIX_TIMESTAMP(created_at) > 86400 * 30')->delete();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\SiteRequest;
use App\Models\PerfRequest;

class DbCleaner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:db-cleaner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleaning up old db requests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      // берем записи старее 2х месяцев
      /*$siteReqs =*/ SiteRequest::whereRaw('UNIX_TIMESTAMP() - UNIX_TIMESTAMP(created_at) > 86400 * 60')->delete();
      /*$perfReqs =*/ PerfRequest::whereRaw('UNIX_TIMESTAMP() - UNIX_TIMESTAMP(created_at) > 86400 * 60')->delete();
      //dd($perfReqs);
      SiteRequest::whereNull('created_at')->delete();
      PerfRequest::whereNull('created_at')->delete();
    }
}

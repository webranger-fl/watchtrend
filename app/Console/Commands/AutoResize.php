<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Sale;

class AutoResize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-resize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto resize for existing images in project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(Sale::all() as $item) {
            if(file_exists(public_path() . '/img/sales/x-360-' . $item->src)) continue;
            \App\Events\ImageUploaded::dispatch(public_path() . '/img/sales/', $item->src);
        }
        
    }
}

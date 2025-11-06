<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteUnusedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unused-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folders = [/*'about',*/ /*'cards',*/ 'categories', 'category_slider', 'main_bg', 'sales', 'service_slider', 'services'];
        $folders = [
          'categories' => \App\Models\category::class,
          'category_slider' => \App\Models\CategoryImage::class,
          'main_bg' => \App\Models\Header::class,
          'sales' => \App\Models\Sale::class,
          'service_slider' => \App\Models\ServiceImage::class,
          'services' => \App\Models\service::class,
        ];
        foreach($folders as $folder => $model) {
          $paths = [];
          foreach($model::all() as $modelItem) {
            $paths[] = $modelItem->src;
          }
          //dd($paths);
          $folderFiles = scandir(public_path() . '/img/' . $folder);
          dd($folderFiles);
          $forDelete = [];
          foreach($folderFiles as $idx => $ff) {
            //if($idx < 2) continue;
            // здесь надо проверить что файл не в списке путей и он не кроп
            //if(!in_array($ff, $paths) && false)
          }
        }
    }
}

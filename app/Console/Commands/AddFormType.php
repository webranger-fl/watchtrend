<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\FormType;

class AddFormType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-form-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      $type = FormType::find(8);
      if($type) return;

      FormType::create([
        'name' => 'Заявки на скидки партнеров',
        'emails' => '139086m@gmail.com',
        'emails_almaty' => '139086m@gmail.com'
      ]);
        
    }
}

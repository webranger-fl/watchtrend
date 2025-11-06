<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoLang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-lang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto wrap texts in @lang directive';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // можно и через view()->getPath, по идее там короче
        $file = "/../../../resources/views/main/vacanciesLanding2.blade.php";
        $content = file_get_contents(dirname(__FILE__) . $file);
        // есть контакт
        //dd($content);
        // баг с двойной оберткой тех строк, которые присутствуют дважды
        preg_match_all("/([а-яА-Яa-zA-Z0-9,: \"«»-]*)<\//u", $content, $matches);
        // можно отфильтровать по идее через array_unique
        $strings = array_filter($matches[1], function($i) {
            return mb_strlen($i) > 10;
        });

        foreach($strings as $s) {
            $content = preg_replace("/$s/u", "@lang('$s')", $content);
        }
        $this->comment = count($strings) . ' occurences are successfully proccessed';

        file_put_contents(dirname(__FILE__) . $file, $content);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Support\Facades\Cache;



class SettingsController extends Controller
{
    public function index()
    {
      //$env = config('app.env');
      $env = env('APP_ENV');
      $laraVer = app()->version();
      $phpVer = phpversion();
      $ip = request()->ip();

      //dd(base_path(). "/bootstrap/cache/routes.php");
      $innerCacheStatus = [];
      $innerCacheStatus['routes'] = file_exists(base_path() . "/bootstrap/cache/routes-v7.php");
      $innerCacheStatus['config'] = file_exists(base_path() . "/bootstrap/cache/config.php");
      $innerCacheStatus['events'] = file_exists(base_path() . "/bootstrap/cache/events.php");

      return view('admin.settings.index', compact('laraVer', 'phpVer', 'ip', 'innerCacheStatus', 'env'));
    }

    public function resetCache(Request $req)
    {
      Cache::flush();
      //ResponseCache::clear();
      $page = parse_url($_SERVER['HTTP_REFERER'])['path'];
      //return redirect()->route('admin.settings.index')->with('msg', 'Кэш сайта очищен');
      return redirect($page)->with('msg', 'Кэш сайта очищен');
    }

    public function cacheAll() {
      // кэширование всей внутрянки Laravel
      // https://laravel.com/docs/10.x/deployment#optimization
      // для config cache нужно заменить все env на config видимо
      Artisan::call('config:cache');
      Log::channel('artisan')->debug(Artisan::output());
      Artisan::call('event:cache');
      Log::channel('artisan')->debug(Artisan::output());
      Artisan::call('route:cache');
      Log::channel('artisan')->debug(Artisan::output());
      Artisan::call('view:cache');
      Log::channel('artisan')->debug(Artisan::output());
      return redirect()->route('admin.settings.index')->with('msg', 'Внутренний кэш Laravel создан');
    }
    public function uncacheAll() {
      // сброс кэша всей внутрянки лары
      //Log::channel('artisan')->debug(Artisan::call('config:clear'));
      //Log::channel('artisan')->debug(Artisan::call('event:clear'));
      //Log::channel('artisan')->debug(Artisan::call('route:clear'));
      //Log::channel('artisan')->debug(Artisan::call('view:clear'));
      Artisan::call('config:clear');
      Log::channel('artisan')->debug(Artisan::output());
      Artisan::call('event:clear');
      Log::channel('artisan')->debug(Artisan::output());
      Artisan::call('route:clear');
      Log::channel('artisan')->debug(Artisan::output());
      Artisan::call('view:clear');
      Log::channel('artisan')->debug(Artisan::output());

      return redirect()->route('admin.settings.index')->with('msg', 'Внутренний кэш Laravel удален');
    }

    public function editFile(Request $req) {
      $filesMap = [
        'robots' => '/public/robots.txt',
        'env' => '/.env'
      ];
      $filePath = $filesMap[$req->file];
      $fileName = $req->file;
      $file = file_get_contents(base_path() . $filePath);

      $fields = [
        ['title' => 'Содержимое файла', 'key' => 'body', 'type' => 'vscode', 'required' => true, 'hint' => "Содержимое файла $filePath"],
      ];

      return view('admin.settings.editFile', compact('fields', 'file', 'filePath', 'fileName'));
    }

    public function patchFile(Request $req) {
      $filesMap = [
        'robots' => '/public/robots.txt',
        'env' => '/.env'
      ];
      $filePath = $filesMap[$req->file];

      file_put_contents(base_path() . $filePath, $req->body);

      return ['ok'];

    }

    public function login() {
      $file = file_get_contents(base_path() . '/routes/auth.php');
      preg_match("/\? 'login' : '([^']*)'/u", $file, $matches);
      //dd($matches);
      $loginUrl = $matches[1];
      //dd($loginUrl);
      //$fields = [['title' => 'URL входа', 'key' => 'url', 'type' => 'text', 'required' => true],];

        return view('admin.settings.secretlogin', compact(['loginUrl']));
    }

    public function loginPatch(Request $req) {
      //dd($req->all());
      $file = file_get_contents(base_path() . '/routes/auth.php');
      //$file = preg_replace("/\? 'login' : '([^']*)'/u", "get('" . $req->loginUrl . "'", $file, 1);
      preg_match("/\? 'login' : '([^']*)'/u", $file, $matches);
      $loginUrl = $matches[1];
      $file = str_replace($loginUrl, $req->url, $file);
      /*$file = file_get_contents(base_path() . '/vendor/laravel/ui/src/AuthRouteMethods.php');
      $file = preg_replace("/get\('([a-z0-9A-Z]*)'/u", "get('" . $req->loginUrl . "'", $file, 1);
      $file = preg_replace("/post\('([a-z0-9A-Z]*)'/u", "post('" . $req->loginUrl . "'", $file, 1);*/
      //dd($file);

      file_put_contents(base_path() . '/routes/auth.php', $file);

      return redirect()->route('admin.settings.login')->with('msg', 'Адрес входа изменен');
    }

    public function setEnv(Request $req) {
      //dd($req->all());
      $envFile = file_get_contents(base_path() . '/.env');
      //dd($envFile);
      $envFile = preg_replace("/APP_ENV=([a-z]*)/u", "APP_ENV=$req->env", $envFile);
      file_put_contents(base_path() . '/.env', $envFile);

      return redirect()->route('admin.settings.index')->with('msg', 'Переменная окружения изменена');
    }



}

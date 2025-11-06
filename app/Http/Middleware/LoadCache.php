<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class LoadCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $req, Closure $next): Response
    {
        $cacheKey = ($_SERVER['REQUEST_URI']) . ':' . App::getLocale();
        // не грузим кэш если HTTP_HOST нет
        if(!isset($_SERVER['HTTP_HOST'])) return $next($req);
        // если GET запрос и в кэше есть ключ
        if($req->getMethod() !== 'GET') return $next($req);
        //dd($cacheKey);
        if(!Cache::has($cacheKey)) return $next($req);
        // и если обращение напрямую по айпишнику на проде, не грузим кэш
        if(config('app.env') !== 'local' && preg_match('/[0-9]/', $_SERVER['HTTP_HOST'])) return $next($req);
        // не грузим и для www
        if(str_contains($_SERVER['HTTP_HOST'], 'www')) return $next($req);
        $scheme = $_SERVER['REQUEST_SCHEME'] ?? "https";
        if(config('app.env') === 'local') $scheme = 'http';
        $host = $scheme."://".$_SERVER['HTTP_HOST'];
        // не кэшируем если хост не совпадает с урлом приложения
        if($host !== config('app.url')) return $next($req);
        // не кэшируем запросы залогиненых
        if(auth()->id()) return $next($req);

        //dd("cache hit!");

        //dd($cacheKey);
        $html = Cache::get($cacheKey);
        // вроде работает!!!
        preg_match('/name="_token" value="([^"]*)"/', $html, $matches);
        //dd($matches);
        if(isset($matches[1])) $html = str_replace($matches[1], csrf_token(), $html);
        //dd($html);
        // возможно здесь стоит логировать perfomance и добавлять инфу что это кэш хит, т.е. доп поле в таблицу перфоманса добавить
        $response = response($html, 200)->withHeaders(['Content-Type' => 'text/html']);
        if(!auth()->id()) {
          \App\Models\PerfRequest::insertOrIgnore(['path' => $_SERVER['REQUEST_URI'] ?? '/', 'execution_time' => round(microtime(true) - LARAVEL_START, 2),
        'created_at' => now(), 'updated_at' => now(), 'cache_hit' => true]);
        }
        return $response;
        //return $res;

        //dd('processing');
        return $next($req);
    }
}

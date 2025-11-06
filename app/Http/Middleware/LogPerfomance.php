<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogPerfomance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      $response = $next($request);
        
      // Perform action
      // не замеряем для залогиненных на проде и типа ботов
      if(auth()->id() && config('app.env') === 'production') return $response;
      // не замеряем для 404х ошибок
      if($response->status() === 404) return $response;
      //if(request()->is_bot) return $response;
      //$path = "/price?utm_source=yandex&utm_medium=temploshadki&utm_campaign=remkvartir&utm_content=cid%7C96144598%7Cgid%7C5286824271%7Caid%7C15020279431%7Cadp%7Cno%7Cdvc%7Cmobile%7Cpid%7C47158907365%7Crid%7C47158907365%7Cdid%7C47158907365%7Cpos%7Cnone0%7Cadn%7Ccontext%7Ccrid%7C0%7C&utm_term=%D1%80%D0%B5%D0%BC%D0%BE%D0%BD%D1%82%20%D0%BE%D0%B4%D0%BD%D0%BE%D0%BA%D0%BE%D0%BC%D0%BD%D0%B0%D1%82%D0%BD%D0%BE%D0%B9%20%D0%BA%D0%B2%D0%B0%D1%80%D1%82%D0%B8%D1%80%D1%8B%20%D1%86%D0%B5%D0%BD%D0%B0&yclid=140065763753632727033";
      //$isBot = isset($_SERVER['HTTP_USER_AGENT']) ? is_bot($_SERVER['HTTP_USER_AGENT']) : true;
      // не логируем для ботов
      if(is_bot($_SERVER['HTTP_USER_AGENT'] ?? '')) return $response;
      \App\Models\PerfRequest::
      //create
      insertOrIgnore(['path' => $_SERVER['REQUEST_URI'] ?? '/', 'execution_time' => round(microtime(true) - LARAVEL_START, 2),
      'created_at' => now(), 'updated_at' => now()]);
   
      return $response;
    }
}

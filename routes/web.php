<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

require __DIR__ . '/web/admin.php';

/*Route::get('/', function () {
    return view('welcome');
});*/

$middlewares = [/*'preApp',*/];
//if(config('app.env') === 'production') $middlewares[] = 'loadCache';
$middlewares[] = 'app';
//if(config('app.env') === 'production') $middlewares[] = 'cacheAfter';
//$middlewares[] = 'logPerfomance';

Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => $middlewares], function() {

  Route::get('/', 'HomeController@index')->name('home');
  Route::post('/', 'HomeController@analyze')->name('analyze');
  Route::post('/devices/{slug:slug}', 'HomeController@devices')->name('devices');

   //Route::get('/trends/oct-2025', 'TrendsController@index')->name('trends');

  Route::get('/key/{slug:slug}', 'KeyController@index')->name('key');
  Route::get('/data/{slug:slug}', 'KeyController@data')->name('data');
  //Route::get('/compare/{slug1:slug}/{slug2:slug}', 'CompareController@index')->name('compare');

  Route::get('/signup', 'UserController@index')->name('signup');

/*Route::get('/', 'BlogController@index')->name('blog');
Route::get('/search', 'BlogController@search')->name('blog.search');
Route::get('/category/{category:slug}/{child:slug?}/{child2:slug?}', 'BlogController@showcategory')
    ->scopeBindings()->name('blog.category');
Route::get('/{category:slug}/{post:slug}', 'BlogController@showPostFirst')
    ->scopeBindings()->name('blog.postFirst');*/

    Route::fallback(function () {
      //Log::debug('404');
      //dd($param['val']);
      if(!auth()->id()) {
        \App\Models\NotFoundHit::insertOrIgnore(['path' => $_SERVER['REQUEST_URI'] ?? '/', 'ip' => $_SERVER['REMOTE_ADDR'], 'created_at' => now(), 'updated_at' => now()]);
      }
      abort(404);
      //return view("errors.404");
    });

});

require __DIR__.'/auth.php';

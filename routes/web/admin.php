<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::get('/profile/sessions', [ProfileController::class, 'sessions'])->name('profile.sessions');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::delete('/profile/session/{session}', [ProfileController::class, 'destroySession'])->name('profile.destroySession');
});

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin/', 'middleware'=>'auth'], function() {
  Route::resource('links', 'LinksController')->names('admin.links');
  Route::resource('quicklink', 'QuicklinkController')->names('admin.quicklink');
  Route::resource('blogCategory', 'BlogCategoryController')->names('admin.blogCategory')->parameters(['blogCategory' => 'item']);

  Route::get('/code', 'CodeController@index')->name('admin.code.index');
  Route::post('/code', 'CodeController@update')->name('admin.code.update');

  Route::get('/wordstat', 'WordstatController@index')->name('admin.wordstat.index');
  Route::get('/wordstat/status', 'WordstatController@status')->name('admin.wordstat.status');
  Route::resource('wordstatPhrase', 'WordstatPhraseController')->names('admin.wordstatPhrase');
  Route::patch('/wordstatPhrases/{wordstatPhrase}/devices', 'WordstatPhraseController@getDevicesData')->name('admin.wordstatPhrase.getDevicesData');

  Route::get('/logs-not-found', 'LogsController@logsNotFound')->name('admin.logsNotFound');

  Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function() {
    Route::get('/', 'IndexController@index')->name('admin.blog.index');
    Route::get('/feedback', 'IndexController@showFeedback')->name('admin.blog.showFeedback');
    Route::get('/feedback/{blog}', 'IndexController@showPostFeedback')->name('admin.blog.showPostFeedback');
    Route::get('/stats', 'IndexController@stats')->name('admin.blog.stats');
    Route::get('/create', 'CreateController@index')->name('admin.blog.create');
    Route::post('', 'StoreController@index')->name('admin.blog.store');
    Route::get('/{blog}', 'ShowController@index')->name('admin.blog.show');
    Route::get('/{blog}/edit', 'EditController@index')->name('admin.blog.edit');
    Route::patch('/{blog}', 'UpdateController@index')->name('admin.blog.update');
    Route::delete('/{blog}', 'DestroyController@index')->name('admin.blog.destroy');
    Route::delete('/feedback/{id}', 'DestroyController@destroyFeedback')->name('admin.blog.destroyFeedback');
});

Route::group(['namespace' => 'Users', 'prefix' => 'user', /*'middleware' => 'redactor'*/], function()
    {
        Route::get('/', 'IndexController@index')->name('admin.user.index');
        Route::get('/create', 'CreateController@index')->name('admin.user.create');
        Route::post('', 'StoreController@index')->name('admin.user.store');
        Route::get('/{user}', 'ShowController@index')->name('admin.user.show');
        Route::get('/{user}/edit', 'EditController@index')->name('admin.user.edit');
        Route::patch('/{user}', 'UpdateController@index')->name('admin.user.update');
        Route::delete('/{user}', 'DestroyController@index')->name('admin.user.destroy');
        Route::patch('/regenpass/{user}', 'StoreController@regenPass')->name('admin.user.regen');
    });

Route::group(['namespace' => 'SEO', 'prefix' => 'seo'], function()
        {
            Route::get('/', 'IndexController@index')->name('admin.seo.index');
            Route::get('/create', 'CreateController@index')->name('admin.seo.create');
            Route::post('', 'StoreController@index')->name('admin.seo.store');
            Route::get('/{seo}', 'ShowController@index')->name('admin.seo.show');
            Route::get('/{seo}/edit', 'EditController@index')->name('admin.seo.edit');
            Route::patch('/{seo}', 'UpdateController@index')->name('admin.seo.update');
            Route::delete('/{seo}', 'DestroyController@index')->name('admin.seo.destroy');
        });

  Route::group(['prefix' => 'settings', 'name' => 'admin.settings.',], function()
    {
      Route::get('/', 'SettingsController@index')->name('admin.settings.index');
      Route::post('/reset', 'SettingsController@resetCache')->name('admin.settings.cache.reset');
      Route::post('/cacheAll', 'SettingsController@cacheAll')->name('admin.settings.cacheAll');
      Route::post('/uncacheAll', 'SettingsController@uncacheAll')->name('admin.settings.uncacheAll');
      Route::post('/setEnv', 'SettingsController@setEnv')->name('admin.settings.setEnv');
      Route::get('/editFile/{file}', 'SettingsController@editFile')->name('admin.settings.editFile');
      Route::post('/patchFile/{file}', 'SettingsController@patchFile')->name('admin.settings.patchFile');
    });

  Route::get('/secretloginurl', 'SettingsController@login')
    //->middleware('redactor')
    ->name('admin.settings.login');

    Route::patch('/secretloginurl', 'SettingsController@loginPatch')
    //->middleware('redactor')
    ->name('admin.settings.loginPatch');

    Route::get('/indexnow', 'IndexNowController@index')
    ->middleware('redactor')
    ->name('admin.indexnow');

    //Route::get('/langs', 'StatsController@langs')->middleware('redactor')->name('admin.langs');
    Route::get('/perf', 'StatsController@perf')/*->middleware('redactor')*/->name('admin.perf');
    Route::get('/metrika', 'MetrikaController@index')->name('admin.metrika');

    Route::get('/crud', 'CrudController@index')->name('admin.crud');
    Route::post('/crud', 'CrudController@store')->name('admin.crud.store');

    /*Route::group(['prefix' => 'tgcontact', 'middleware' => 'redactor'], function() {
      Route::get('/', 'TgContactController@index')->name('admin.tgcontact.index');
      Route::get('/create', 'TgContactController@create')->name('admin.tgcontact.create');
      Route::post('', 'TgContactController@store')->name('admin.tgcontact.store');
      Route::get('/{tg}/edit', 'TgContactController@edit')->name('admin.tgcontact.edit');
      Route::patch('/{tg}', 'TgContactController@update')->name('admin.tgcontact.update');
      Route::delete('/{tg}', 'TgContactController@destroy')->name('admin.tgcontact.destroy');
    });*/

  Route::group(['prefix' => 'backups'], function() {
    Route::get('/', 'BackupsController@index')->name('admin.backups');
    Route::post('/store', 'BackupsController@store')->name('admin.backups.store');
    Route::post('/gd', 'BackupsController@gdStore')->name('admin.backups.storeGd');
  });
});
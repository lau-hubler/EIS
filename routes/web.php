<?php

use Illuminate\Support\Facades\Route;

// Localization
Route::get('js/lang-{locale}.js', function ($locale) {
    if (!array_key_exists($locale, config('app.locales'))) {
        $locale = config('app.fallback_locale');
    }
    if(env('APP_ENV','none') === 'local') {
        Cache::forget("lang-{$locale}.js");
    }

    $strings = Cache::rememberForever("lang-{$locale}.js", function () use ($locale) {
        $dir = resource_path('lang/' . $locale);
        $strings = [];
        function recursiveGetLangFiles ($dir, &$strings) {
            $dir = glob($dir . '/*');
            foreach($dir as $file) {
                if (is_file($file)) {
                    $strings[basename($file, '.php')] = require $file;
                }
                else if (is_dir($file)) {
                    recursiveGetLangFiles($file, $strings[basename($file)]);
                }
            }
        }
        recursiveGetLangFiles($dir, $strings);
        return $strings;
    });

    $contents = 'window.i18n = ' . json_encode($strings, config('app.debug', false) ? JSON_PRETTY_PRINT : 0) . ';';
    return  response($contents, 200, ['Content-Type' => 'text/javascript']);
})->name('assets.lang');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function() {
    Route::apiResource('/categories', 'CategoryController');
});



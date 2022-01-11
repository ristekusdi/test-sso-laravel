<?php

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

use App\Http\Controllers\WebSessionController;

require __DIR__.'/sso.php';

Route::get('/', function () {
    return view('home');
})->middleware('sso-web');

Route::post('/web-session/change-role-active', [WebSessionController::class, 'changeRoleActive'])->middleware('sso-web');
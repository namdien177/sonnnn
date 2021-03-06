<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/news', 'NewsController@indexNews');
Route::post('/news/upload','NewsController@storeNews');
Route::post('/news/update','NewsController@updateNews');
Route::post('/news/comment/upload','NewsController@storeNewsComment');

Route::get('/maps','NewsController@indexMaps');

Route::get('/teams','NewsController@indexTeams');
Route::get('/teams/{id}','NewsController@showTeam');
Route::get('/teams/{id}/leader','NewsController@showTeamLeader');
Route::get('/teams/{id}/matches','NewsController@showTeamMatches');

Route::get('/players','NewsController@indexPlayers');
Route::get('/players/{id}','NewsController@showPlayer');

Route::group([

    'middleware' => 'api'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});


<?php

use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\VideoController;
use App\Models\Competition;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function (){
    return view('auth.login');
})->name('home');

Route::group(['middleware' => 'auth:web'],function (){
    Route::resource('videos',VideoController::class)->only(['create','store']);
    Route::get('competitions',[CompetitionController::class,'index'])->name('allCompetition');
    Route::get('competition/videos/{id}',[CompetitionController::class,'competitionVideos'])->name('competitionVideos');
    Route::post('competition/videos/rating',[RatingController::class,'competitionVideosRating'])->name('competitionVideosRating');


});

Route::get('check',function (){


});

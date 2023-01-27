<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\ExploreController;

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

# Clear all for debugging
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return "Cache cleared";
});

Route::get('/', function () { return view('welcome'); });

Route::middleware('auth')->group(function () {


    // ---------------------------------------------------------------- Tweets

    Route::get('/home', [
        TweetController::class, 'index' ] )->name('tweets.index');

    Route::post('/more-tweets', [
        TweetController::class, 'moreTweets' ] )->name('more-tweets');

    Route::post('/tweets', [ TweetController::class, 'store' ] )->name('store-tweet');

    Route::post('/delete-tweet', [ TweetController::class, 'destroy' ] );

    Route::post('/new-tweets', [ TweetController::class, 'getNewTweetsForCurrentUser' ] );


    // --------------------------------------------------------------- Explore

    Route::get('/explore', [ ExploreController::class, 'index' ] )->name('explore');


    // -------------------------------------------------------- User's Profile

    Route::get('/profiles/{user:username}', [
        UserProfileController::class, 'show' ] )->name('user-profile');

    Route::post('/more-profiles-tweets/{user:username}', [
        UserProfileController::class, 'showMoreProfileTweets' ] )->name('more-profile-tweets');


    // --------------------------------------------------------------- Follows

    Route::post('/profiles/{user:username}/follow', [
        FollowsController::class, 'store' ] )->name('follow');


    // ------------------------------------------------ Default Laravel Profile

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';

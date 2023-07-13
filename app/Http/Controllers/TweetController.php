<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('tweets.index', [
            'tweets' => auth()->user()->timeline()
        ]);
    }

    /**
     * Display a listing of the resource (more 'tweets' if scrolling down the page).
     *
     * @return View
     */
    public function moreTweets(): View
    {
        return view('tweets.more-tweets', [
            'tweets' => auth()->user()->moretimeline(request()->skip)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return View
     */
    public function store(): View
    {
        request()->validate([
            'body' => 'required|string|max:255'
        ]);

        Tweet::create([
            'user_id' => request('userId'),
            'body' => request('body')
        ]);

        return view('tweets.new-tweet', [
            'tweet' => Tweet::latest()->first()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     */
    public function destroy(): void
    {
        Tweet::find(request('tweetId'))->delete();
    }

    /**
     * Get new 'tweets' for the current user using AJAX.
     *
     * @return View
     */
    public function getNewTweetsForCurrentUser(): View
    {
        // Get the IDs of users that the current user is following
        $ids = DB::table('follows')
            ->where('user_id', request('userId'))
            ->select('following_user_id')
            ->pluck('following_user_id')
            ->toArray();

        // Get new 'tweets'
        $tweets = Tweet::where('id', '>', request('tweetLastId'))
            ->whereIn('user_id', $ids)
            ->latest()
            ->get();

        // If there are new 'tweets'
        if ($tweets->count()) {
            return view('tweets.new-tweet-ajax', ['tweets' => $tweets]);
        }
    }
}

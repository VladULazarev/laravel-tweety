<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use DB;

class TweetController extends Controller
{
    //use Followable;

    /**
     * Display a listing of the resource.
     *
     * @see method timeline() in App\Models\User;
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('tweets.index', [
            'tweets' => auth()->user()->timeline()
        ]);
    }

    /**
     * Display a listing of the resource. (More 'tweets' if scroll down the page)
     *
     * @see method timeline() in App\Models\User;
     * @see public\build\assets\app.js -- 2. Show more 'tweets'
     * @return \Illuminate\View\View
     */
    public function moreTweets()
    {
        return view('tweets.more-tweets', [
            'tweets' => auth()->user()->moretimeline(request()->skip)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @see public\build\assets\app.js -- 4. Store and show the new 'tweet'
     *
     * @return \Illuminate\View\View
     */
    public function store()
    {
        request()->validate(['body' => 'required|string|max:255']);

        Tweet::create([
            'user_id' => request('userId'),
            'body'    => request('body')
        ]);

        return view('tweets.new-tweet', [
            'tweet' => Tweet::latest()->first()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int request('tweetId') from public\build\assets\app.js -- 3. Delete the 'tweet'
     */
    public function destroy(): void
    {
        Tweet::find(request('tweetId'))->delete();
    }

    /**
     * Get new 'tweets' for the current user using 'ajax'
     *
     * @see public\build\assets\app.js --- 5. Get new 'tweets' for current user using 'ajax'
     *
     * @return \Illuminate\View\View
     */
    public function getNewTweetsForCurrentUser()
    {
        # Get 'ids' of users which the current user is following
        $ids = DB::table('follows')
        ->where('user_id', request('userId'))
        ->select('following_user_id')
        ->pluck('following_user_id')
        ->toArray();

        # Get new 'tweets'
        $tweets = Tweet::where( 'id', '>', request('tweetLastId') )
        ->whereIn('user_id', $ids)
        ->latest()
        ->get();

        # If there are new 'tweets'
        if ($tweets->count()) {
            return view('tweets.new-tweet-ajax', [ 'tweets' => $tweets ]);
        }
    }

}

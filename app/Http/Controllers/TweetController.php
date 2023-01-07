<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class TweetController extends Controller
{
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        request()->validate(['body' => 'required|string|max:255']);

        Tweet::create([
            'user_id' => auth()->id(),
            'body'    => request('body')
        ]);

        return to_route('tweets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int request('tweetId') from public\build\assets\app.js -- 3. Delete the 'tweet'
     */
    public function destroy()
    {
        Tweet::find(request('tweetId'))->delete();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource ('tweets' by a user on /profiles/{$user} page)
     *
     * @see method 'tweets()' in App\Models\User;
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users-profiles.show', [
            'user' => $user,
            'tweets' => auth()->user()->tweets($user)
        ]);
    }

    /**
     * Display a listing of the resource (more 'tweets' by a user on /profiles/{$user} page)
     *
     * @see method 'moreProfileTweets($user)' in App\Models\User;
     * @return \Illuminate\View\View
     */
    public function showMoreProfileTweets(User $user)
    {
        return view('tweets.more-tweets', [
            'user' => $user,
            'tweets' => auth()->user()->moreProfileTweets($user, request()->skip)
        ]);
    }
}

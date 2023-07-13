<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource ('tweets' by a user on /profiles/{$user} page)
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('users-profiles.show', [
            'user' => $user,
            'tweets' => auth()->user()->tweets($user)
        ]);
    }

    /**
     * Display a listing of the resource (more 'tweets' by a user on /profiles/{$user} page)
     *
     * @param User $user
     * @return View
     */
    public function showMoreProfileTweets(User $user): View
    {
        return view('tweets.more-tweets', [
            'user' => $user,
            'tweets' => auth()->user()->moreProfileTweets($user, request()->skip)
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;

class FollowsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(User $user)
    {
        /**
         * @see method 'toggleFollow' in: app\Http\Traits\Followable.php
         */
        auth()->user()->toggleFollow($user);

        return back();
    }
}

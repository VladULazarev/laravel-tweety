<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class FollowsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(User $user): RedirectResponse
    {
        /**
         * @see method 'toggleFollow' in: app\Http\Traits\Followable.php
         */
        auth()->user()->toggleFollow($user);

        return back();
    }
}

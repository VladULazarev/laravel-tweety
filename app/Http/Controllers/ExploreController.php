<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class FollowsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function store(User $user): RedirectResponse
    {
        auth()->user()->toggleFollow($user);
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;

class ExploreController extends Controller
{
    /**
     * Display a listing of the resource (all existing users).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('explore.index', [ 'users' => User::get() ]);
    }
}

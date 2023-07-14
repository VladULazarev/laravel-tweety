<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class ExploreController extends Controller
{
    /**
     * Display a listing of the resource (all existing users).
     *
     * @return View
     */
    public function index(): View
    {
        return view('explore.index', [ 'users' => User::get() ]);
    }
}

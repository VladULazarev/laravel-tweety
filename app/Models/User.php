<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Traits\Followable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Followable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'avatar',
        'user_desc',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get 'tweets' by the auth->user and the users he/she follows
     *
     * @see method timeline() in: app\Http\Controllers\TweetController.php
     *
     * @return \Illuminate\Http\Response
     */
    public function timeline()
    {
        $ids = $this->follows()->pluck('id')->toArray();

        array_push($ids, $this->id);

        return Tweet::whereIn('user_id', $ids)->latest()->take(10)->get();
    }

    /**
     * Get more 'tweets' by the auth->user and the users he/she follows
     * (if scroll down the page)
     *
     * @see public\build\assets\app.js -- 2. Show more 'tweets'
     *
     * @see method moretimeline() in: app\Http\Controllers\TweetController.php
     *
     * @return \Illuminate\Http\Response
     */
    public function moretimeline($skip)
    {
        $ids = $this->follows()->pluck('id')->toArray();

        array_push($ids, $this->id);

        return Tweet::whereIn('user_id', $ids)
        ->latest()
        ->skip($skip)
        ->take(10)
        ->get();
    }

    /**
     * Get user's 'tweets' for 'profiles/{user}' page
     *
     * @see method tweets() in: app\Http\Controllers\UserProfileController.php
     *
     * @return \Illuminate\Http\Response
     */
    public function tweets($user)
    {
        return Tweet::where('user_id', $user->id)->latest()->take(10)->get();
    }

    /**
     * Get more user's 'tweets' for 'profiles/{user}' page
     *
     * @see public\build\assets\app.js -- 2. Show more 'tweets'
     * @see method moreProfileTweets() in: app\Http\Controllers\UserProfileController.php
     *
     * @return \Illuminate\Http\Response
     */
    public function moreProfileTweets($user, $skip)
    {
        return Tweet::where('user_id', $user->id)
        ->latest()
        ->skip($skip)
        ->take(10)
        ->get();
    }

    /**
     * Get user's avatar
     *
     * @return string Url for user's avatar
     */
    public function getAvatarAttribute($value)
    {
        // return "https://i.pravatar.cc/50?u=" . $this->email;
        return asset($value);
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function path()
    {
        return route('user-profile', $this);
    }
}

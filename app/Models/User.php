<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Traits\Followable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Expr\Cast\Object_;

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
     */
    public function timeline()
    {
        $ids = $this->follows()->pluck('id')->push($this->id);

        return Tweet::whereIn('user_id', $ids)->latest()->take(10)->get();
    }

    /**
     * Get more 'tweets' by the auth->user and the users he/she follows
     * (if scroll down the page)
     *
     * @param $skip
     * @return mixed
     * @see public\build\assets\app.js -- 2. Show more 'tweets'
     */
    public function moreTimeline($skip): mixed
    {
        $ids = $this->follows()->pluck('id')->push($this->id);

        return Tweet::whereIn('user_id', $ids)
            ->latest()
            ->skip($skip)
            ->take(10)
            ->get();
    }

    /**
     * Get user's 'tweets' for 'profiles/{user}' page
     *
     * @param $user
     * @return mixed
     */
    public function tweets($user): mixed
    {
        return Tweet::where('user_id', $user->id)->latest()->take(10)->get();
    }

    /**
     * Get more user's 'tweets' for 'profiles/{user}' page
     *
     * @param $user
     * @param $skip
     * @return mixed
     * @see method moreProfileTweets() in: app\Http\Controllers\UserProfileController.php
     * @see public\build\assets\app.js -- 2. Show more 'tweets'
     */
    public function moreProfileTweets($user, $skip): mixed
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
    public function getAvatarAttribute($value): string
    {
        // return "https://i.pravatar.cc/50?u=" . $this->email; // debugging
        return asset($value);
    }

    public function getRouteKeyName(): string
    {
        return 'username';
    }

    public function path(): string
    {
        return route('user-profile', $this);
    }
}

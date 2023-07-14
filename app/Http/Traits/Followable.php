<?php

namespace App\Http\Traits;

use App\Models\User;

trait Followable
{
    /**
     * Set a user to follow
     */
    public function follow(User $user)
    {
        return $this->follows()->save($user);
    }

    /**
     * Set a user to unfollow
     */
    public function unfollow(User $user)
    {
        return $this->follows()->detach($user);
    }

    /**
     * Toggle a user follow/unfollow
     */
    public function toggleFollow($user)
    {
        $this->follows()->toggle($user);
    }

    /**
     * Check if the auth->user already follows the current user
     *
     * @return bool 'true' if already follows (the record exists), otherwise 'false'
     */
    public function following(User $user): bool
    {
        return $this->follows()
        ->where('following_user_id', $user->id)
        ->exists();
    }

    /**
     * Get users 'auth->user' are following
     *
     * @return BelongsToMany
     */
    public function follows(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id');
    }
}

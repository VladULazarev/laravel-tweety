<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // ----------------------------------------------------- Store 'Avatar'

        if ( $request->file('avatar') ) {

            $avatar = $request->file('avatar');

            # Set a new avatar name
            $avatarName = Str::random(8) . '.jpg';

            # Cut the new avatar
            $manager = new ImageManager;

            $avatar = $manager->make($avatar)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            # Set directory for the new avatar
            $avatarDir = public_path('storage/avatars/' . $request->user()->id);

            if ( File::isDirectory( $avatarDir ) ) {
                File::deleteDirectory( $avatarDir );
                File::makeDirectory($avatarDir, 0755, true, true);
            } else {
                File::makeDirectory($avatarDir, 0755, true, true);
            }

            # Save the new avatar
            $avatar->save( $avatarDir . '/' . $avatarName);

            # Set the path of the 'avatar' for 'users' table
            $request->user()->avatar = 'public/storage/avatars/' . $request->user()->id . '/' . $avatarName;
        }

        # Save updated profile
        $request->user()->save();

        # return Redirect::route('profile.edit')->with('status', 'profile-updated');
        return redirect($request->user()->path());
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        // Set user's directory to delete
        $avatarDir = public_path('storage/avatars/' . $request->user()->id);

        // Delete user's directory
        File::deleteDirectory( $avatarDir );

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

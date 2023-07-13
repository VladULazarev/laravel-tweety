<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // ----------------------------------------------------- Store 'Avatar'

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            // Set a new avatar name
            $avatarName = Str::random(8) . '.jpg';

            // Resize and store the new avatar
            $manager = new ImageManager;
            $avatar = $manager->make($avatar)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $avatarDir = public_path('storage/avatars/' . $user->id);
            if (File::isDirectory($avatarDir)) {
                File::deleteDirectory($avatarDir);
            }
            File::makeDirectory($avatarDir, 0755, true, true);
            $avatar->save($avatarDir . '/' . $avatarName);

            // Set the path of the 'avatar' for 'users' table
            $user->avatar = 'public/storage/avatars/' . $user->id . '/' . $avatarName;
        }

        // Save the updated profile
        $user->save();

        return redirect($user->path());
    }

    /**
     * Delete the user's account.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        // Delete the user's directory
        $avatarDir = public_path('storage/avatars/' . $user->id);
        File::deleteDirectory($avatarDir);

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

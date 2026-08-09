<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class userProfileController extends Controller
{
    public function updateUserInfo(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'fname' => ['nullable', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('customers', 'username')->ignore($user->id)],
        ]);

        // The old rule was a bare unique() with no ignore(), so saving the form
        // without changing the username failed against the user's own row.
        $user->update(array_filter($validated, fn ($value) => filled($value)));

        return redirect()->back()->with(['success' => 'Updating Success!']);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        Auth::user()->update([
            'profile' => $request->file('profile')->store('images', 'public'),
        ]);

        return redirect()->back()->with('success', 'Profile updated!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => ['required'],
            'newPassword' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'confirmPassword' => ['required', 'same:newPassword'],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->oldPassword, $user->password)) {
            return redirect()->back()->with(['Fail' => 'Wrong Password!']);
        }

        $user->update(['password' => $request->newPassword]);

        return redirect()->back()->with(['success' => 'Password changed successfully!']);
    }

    /**
     * Upload a government ID for review.
     *
     * These were stored in storage/app/public under the uploader's own
     * filename, symlinked into the web root and served with no authorization —
     * a passport scan was readable by anyone who guessed the name. They now go
     * to the private disk and are only readable through AdminFileController.
     */
    public function uploadID(Request $request)
    {
        $request->validate([
            'validID' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        Auth::user()->update([
            'valid_id_path' => $request->file('validID')->store('valid-ids', 'private'),
        ]);

        return redirect()->back()->with(
            'submitSuccess',
            'Thank you for submitting your ID, your account will be verified within 24h'
        );
    }
}

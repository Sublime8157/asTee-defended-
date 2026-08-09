<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class adminIndexController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function managePassword()
    {
        return view('admin.managePassword');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => ['required'],
            'newPassword' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'confirmPassword' => ['required', 'same:newPassword'],
        ]);

        $admin = Auth::guard('admin')->user();

        if (! Hash::check($request->oldPassword, $admin->password)) {
            return back()->withErrors(['oldPassword' => 'Password Incorrect']);
        }

        $admin->update(['password' => $request->newPassword]);

        return redirect()->back()->with(['success' => 'Password Changed Successfully']);
    }

    public function adminLogin(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (auth()->guard('admin')->attempt($validated)) {
            $admin = auth()->guard('admin')->user();

            // Was `> 0` on a timestamp column, which compared a datetime string
            // to an integer.
            if ($admin->email_verified_at !== null) {
                $request->session()->regenerate();

                return redirect('/dashboard');
            }

            auth()->guard('admin')->logout();

            return back()->withErrors(['fail' => 'This user has not been verified yet, please contact your administrator']);
        }

        return back()->withErrors(['username' => 'Invalid Credentials'])->withInput();
    }

    public function adminLogout(Request $request)
    {
        auth()->guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/loginAdmin');
    }

    public function feedbacks()
    {
        return view('admin.feedbacks', [
            'reviews' => Review::with(['user', 'orderItem'])->latest()->get(),
        ]);
    }

    /** Toggle a review onto the homepage. */
    public function toFeature(int $id)
    {
        $review = Review::findOrFail($id);

        // Was a one-way write of the integer 2, while the insert always wrote 1
        // and the homepage queried for 2 — a review could be featured but never
        // un-featured.
        $review->update(['is_featured' => ! $review->is_featured]);

        return redirect()->back();
    }
}

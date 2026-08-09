<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class LoginSignupController extends Controller
{
    public function LoginSignup()
    {
        return view('login.registration.login');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:20'],
            'birthday' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('customers', 'email')],
            'username' => ['required', 'string', 'max:255', Rule::unique('customers', 'username')],
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        // `userStatus` was `required|numeric` and came from the registration
        // form, so the account's blocked state was picked by whoever signed up.
        $user = User::create($validated + ['profile' => 'default.png']);

        Mail::to($user->email)->send(new VerificationEmail($user->email));

        return view('user.emailSent');
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (! auth()->attempt($validated)) {
            return back()->withErrors(['username' => 'Invalid Credentials'])->withInput();
        }

        $user = auth()->user();

        if ($user->isBlocked()) {
            $this->logout($request);

            return redirect()->route('userLogin')->with([
                'fail' => 'This user has been blocked by admin, please contact us for more clarification, thank you!',
            ]);
        }

        if ($user->email_verified_at === null) {
            $email = $user->email;
            $this->logout($request);

            return redirect('/verifyEmail2')->with('email', $email);
        }

        // The parallel session keys (isLoggedin, id, username, profile,
        // verification) are gone. Views and middleware read the guard, so there
        // is only one place a session can disagree with the database.
        $request->session()->regenerate();

        return redirect('/home');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * "Find my account" before a password reset.
     *
     * Was a LIKE %input% that returned every partial match — id, username and
     * email — and rendered them into editable inputs on a public page: a user
     * enumeration endpoint. It now confirms at most the one exact account and
     * says the same thing either way.
     */
    public function searchUser(Request $request)
    {
        $validated = $request->validate([
            'search' => ['required', 'string', 'max:255'],
        ]);

        $found = User::where('username', $validated['search'])
            ->orWhere('email', $validated['search'])
            ->exists();

        if (! $found) {
            return redirect()->back()->with([
                'noResult' => 'No user found, make sure to input the correct username or email',
            ]);
        }

        return redirect()->route('foundUser')->with('account', $validated['search']);
    }
}

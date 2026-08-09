<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserCustomResetPasswordMail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserCustomizeForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected function broker()
    {
        return Password::broker('users');
    }

    /**
     * Send a reset link to the given user.
     *
     * @return JsonResponse|RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $request->only('email'),
            function ($user, $token) {
                Mail::to($user->email)->send(new UserCustomResetPasswordMail($token, $user->email));
            }
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return JsonResponse|RedirectResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        // Customize the success message or redirect here
        return redirect()->back()->with('success', 'Successfully sent to your email');
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  string  $response
     * @return JsonResponse|RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\UserFeedbackMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function sendToEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Mail::to(config('mail.inboxes.feedback'))->send(new UserFeedbackMail($validated));

        return redirect()->back()->with(['Success' => 'Thank you for your feedback!']);
    }
}

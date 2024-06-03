<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserFeedbackMail;

class ContactUsController extends Controller
{
    public function sendToEmail(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'message' => 'required'
        ]);

        $feedbackInfo = [
            'name' => $validated['name'],
            'message' => $validated['message'],
            'email' => $request->email
        ];

        Mail::to('asteefeedbacks@astee.store')->send(new UserFeedbackMail($feedbackInfo));

        return redirect()->back()->with(['Success' => 'Thank you for your feedback!']);
    }   
}

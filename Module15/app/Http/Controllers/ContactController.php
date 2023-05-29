<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];

        Mail::send('emails.contact', $data, function ($message) {
            $message->to('your-email@example.com')
                    ->subject('Contact Form Submission');
        });

        return redirect()->back()->with('success', 'Thank you for your message!');
    }
}


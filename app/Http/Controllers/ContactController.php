<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    /**
     * Show the contact page.
     */
    public function show()
    {
        return view('pages.contact');
    }

    public function send(ContactRequest $request)
    {
        // Determine recipient based on environment
        if (in_array(app()->environment(), ['local', 'staging'])) {
            $recipient = env('CONTACT_RECIPIENT_EMAIL');
        } else {
            // Production: no production email, this is just a demo
            return back()->with('success', 'This is a demo. No email was sent.');
        }

        // Prepare email data
        $data = $request->only(['first_name', 'last_name', 'email', 'message']);

        // Add a prefix to subject in dev/staging
        $subject = ($request->subject ?: 'New Message from Contact Us');
        if (app()->environment('local')) {
            $subject = '[DEV] ' . $subject;
        } elseif (app()->environment('staging')) {
            $subject = '[STAGING] ' . $subject;
        }

        // Send email
        Mail::raw(
            "Name: {$data['first_name']} {$data['last_name']}\n".
            "Email: {$data['email']}\n\n".
            "Message:\n{$data['message']}",
            function ($message) use ($data, $recipient, $subject) {
                $message->to($recipient)
                    ->subject($subject)
                    ->replyTo($data['email'], $data['first_name'].' '.$data['last_name']);
            }
        );

        // Return success message
        return back()->with('success', 'Thank you ! Your message has been sent!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;

use App\Mail\ContactUsMail;

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
        // Prepare email data
        $data = $request->only(['first_name', 'last_name', 'email', 'subject', 'user_message']);

        Mail::to(config('mail.to.address'))->send(new ContactUsMail($data));

        // Return success message
        return back()->with('success', 'Thank you ! Your message has been sent. We will get back to you shortly.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create([
            'UserId' => Auth::id(),
            'FirstName' => $request->first_name,
            'LastName' => $request->last_name,
            'Email' => $request->email,
            'Subject' => $request->subject,
            'Message' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }
}

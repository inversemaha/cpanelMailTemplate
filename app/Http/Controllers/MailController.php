<?php

namespace App\Http\Controllers;

use App\Mail\QBLabMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|email'
        ]);
        $email = $data['email'];

        $body = [
            'name'=>$data['name'],
            'url_a'=>'https://qubitsolutionlab.com//',
        ];

        Mail::to($email)->send(new QBLabMail($body));
        return back()->with('status','Mail sent successfully');;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Mail;

class ActivationController extends Controller
{
    public function index()
    {
        return view('auth.activate');
    }
    public function resendactivateview()
    {
        return view('auth.resendactivate');
    }
    public function activate(Request $request)
    {
        $_user  = new User();
        $user = $_user->where('email', 'like', $request->email)->where('activation_code', '=', $request->code)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Wrong Credentials');
        } else {
            $user->email_verified_at = Carbon::now();
            $user->status = 1;
            $user->save();
            return redirect('/login')->withSuccess('your account has been activated');
        }
    }
    public function resendactivate(Request $request)
    {
        $_user  = new User();
        if ($request->email != null) {
            $user = $_user->where('email', 'like', $request->email)->first();
            if ($user) {
                if ($user->email_verified_at == NULL) {
                    $this->sendEmail($user, $user->activation_code);
                } else {
                    return redirect()->back()->with('success', "you don't need to activate your account because has been activated");
                }
            }
            return redirect()->back()->with('success', 'an email has been sent');
        } else {
            return redirect()->back()->with('error', 'you must enter the email field');
        }
    }
    private function sendEmail($user, $code)
    {
        Mail::send('email.activation', [
            'user' => $user,
            'code' => $code
        ], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject("Hello $user->name, activate your account");
        });
    }
}

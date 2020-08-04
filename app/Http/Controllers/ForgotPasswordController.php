<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Mail;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgotpass');
    }
    public function forgotpass(Request $request)
    {
        $_user = new User();
        if ($request->email == "") {
            return redirect('/forgotpass')->with('error', 'Please enter a valid email');
        }
        $user = $_user->where('email', 'like', $request->email)->first();
        if ($user) {
            $newpass = $this->uniqid(8);
            $user->password = md5($newpass);
            $user->save();
            $this->sendEmailForgot($user, $newpass);
        }
        return redirect('/forgotpass')->with('success', 'A new password has been sent to your email');
    }
    private function sendEmailForgot($user, $code)
    {
        Mail::send('email.forgot-password', [
            'user' => $user,
            'code' => $code
        ], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject("Hello $user->name, a new password has been sent");
        });
    }
    public function uniqid($length)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $length);
    }
}

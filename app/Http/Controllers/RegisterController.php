<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Mail;
use File;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'username' => 'required|min:4|max:20|alpha_num|string|unique:users',
            'name'  => 'required|max:64|regex:/^[\pL\s\-]+$/u|string',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|min:6|max:14|confirmed',
        ]);
        if ($validator->fails()) {
            return  redirect()->back()->withErrors($validator->errors());
        }
        $user = new User();
        $getemail = $user->where('email', 'like', $request->email)->get()->count();
        $getusername = $user->where('username', '=', $request->username)->get()->count();
        if ($getemail || $getusername > 0) {
            return redirect()->back()->with('error', 'Email or Username already registered');
        } else {
            $uniqid = $this->uniqid(12);
            while ($user->where('user_id', '=', $uniqid)->get()->count() > 0) {
                $uniqid = $this->uniqid(12);
            }
        }
        $user->user_id = $uniqid;
        $user->email = strtolower($request->email);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = md5($request->password);
        $activation = md5(uniqid(mt_rand(), true));
        $user->activation_code = $activation;
        if (!$user->save()) {
            return redirect()->back()->with('error', 'Registration Failed');
        } else {
            $this->sendEmail($user, $activation);
            return  redirect('login')->withSuccess('Registration Sucessful, an activation code have been sent to your email account');
        }
    }
    public function uniqid($length)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz+&_ABCDEFGHIJKLMOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $length);
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

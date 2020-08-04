<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserLogModel;
use Illuminate\Support\Facades\Cookie;
use Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        $user = new User();
        if ($this->isEmail($request->uID)) {
            //user sent their email 
            $_user = $user->where('email', 'like', $request->uID)->where('password', '=', $request->password)->first();
            if ($_user) // not registered
            {
                if ($_user->status == 0) // not activated
                {
                    return redirect()->back()->with('error', 'You must activate your Account');
                } else if ($_user->status == -1) {     // account locked             
                    return redirect()->back()->with('error', 'Your account has been locked');
                }
                // $userupdate = $user->where('email','like',$request->uID)->update(['last_login'=>now()]);
                $this->rememberme($request->remember, $request->uID, $request->password);
                $this->setSessionLogin($request, $_user);
                $userlog = new UserLogModel();
                $log = $userlog->insertlog($_user->user_id, 5);
                return redirect('/browse');
                // go to home
            }
        } else {
            //they sent their username instead 
            $_user =  $user->where('username', '=', $request->uID)->where('password', '=', $request->password)->first();
            if ($_user) {
                if ($_user->role == 1) {
                    return redirect('/admin')->with('info', 'Please login using this page for administrator');
                }
                if ($_user->status == 0) {
                    return redirect()->back()->with('error', 'You must activate your Account');
                } else if ($_user->status == -1) {
                    return redirect()->back()->with('error', 'Your account has been locked');
                }
                $this->rememberme($request->remember, $request->uID, $request->password);
                $this->setSessionLogin($request, $_user);
                $userupdate = $user->where('username', '=', $request->uID)->update(['last_login' => now()]);
                $userlog = new UserLogModel();
                $log = $userlog->insertlog($_user->user_id, 5);
                return redirect('/browse');
                // go to home
            }
        }
        return redirect()->back()->with('error', 'Wrong Credentials');
    }
    public function isEmail($value)
    {
        //cek valid email
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    public function rememberme($remember, $uID, $uPASS)
    {
        if ($remember) {
            Cookie::queue('uID', $uID);
            Cookie::queue('uPASS', $uPASS);
        } else {
            Cookie::forget('uID');
            Cookie::forget('uPASS');
        }
    }
    public function setSessionLogin(Request $request, $user)
    {
        Session::put('user', $user);
        Session::save();
    }
    public function logout()
    {
        if (Session::get('user')) {
            $userlog = new UserLogModel();
            $log = $userlog->insertlog(Session::get('user')->user_id, 4);
        }
        Session::flush();
        Session::flush();
        Session::flush();
        sleep(5);
        return redirect('/');
    }
}

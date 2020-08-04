<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\User;
use Session;
use App\Followers;
use App\Notifications;

class UserController extends Controller
{
    public function viewprofile($uID)
    {
        $_followers = new Followers();
        $_user = new User();
        $user = $_user->where('user_id', '=', $uID)->first(['user_id', 'name', 'email', 'about', 'profpic', 'website']);
        $followerid = Session::get('user')->user_id;
        $youraccount = false;
        if ($uID == $followerid) {
            $youraccount = true;
        }
        $follower = $_followers->where('user_id', '=', $uID)->where('follower_id', '=', $followerid)->get(['follower_id']);
        $isfollowing = false;
        if ($follower->count() > 0) {
            $isfollowing = true;
        } else {
            $isfollowing = false;
        }
        return view('viewprofile', array('user' => $user, 'isfollowing' => $isfollowing, 'youraccount' => $youraccount, 'lastsegment' => $uID));
    }
    public function viewnotif()
    {
        $uid  = Session::get('user')->user_id;
        $_notif = new Notifications();
        // $notif = $_notif->where('recipient','=',$uid)->where('isRead','=',0)->update(['isRead'=>1]);
        $viewnotif = $_notif->where('recipient', '=', $uid)->where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('notifications', array('notif' => $viewnotif));
    }
    public function markasread($id = "")
    {
        $uid  = Session::get('user')->user_id;
        $_notif = new Notifications();
        $notif = $_notif->where('recipient', '=', $uid)->where('id', '=', $id)->update(['isRead' => 1]);
        $viewnotif = $_notif->where('recipient', '=', $uid)->where('status', 1)->orderBy('created_at', 'desc')->get();
        return redirect('/notifications');
    }
    public function markallasread()
    {
        $uid  = Session::get('user')->user_id;
        $_notif = new Notifications();
        $notif = $_notif->where('recipient', '=', $uid)->where('isRead', '=', 0)->update(['isRead' => 1]);
        $viewnotif = $_notif->where('recipient', '=', $uid)->where('status', 1)->orderBy('created_at', 'desc')->get();
        return redirect('/notifications');
    }

    public function ajaxnotif()
    {
        $uid  = Session::get('user')->user_id;
        $_notif = new Notifications();
        $notif = $_notif->where('recipient', '=', $uid)->where('isRead', '=', 0)->limit(10)->get();
        return $notif->toJson();
    }
    public function countnewnotif()
    {
        $uid  = Session::get('user')->user_id;
        $_notif = new Notifications();
        $notif = $_notif->where('recipient', '=', $uid)->where('isRead', '=', 0)->count();
        return $notif;
    }
    public function dismissnotif($id)
    {
        $_notif = new Notifications();
        $notif = $_notif->where('id', '=', $id)->first();
        $notif->isRead = 1;
        $notif->status = 0;
        if ($notif->save()) {
            return redirect('/notifications');
        } else {
            return 'error';
        }
    }
    public function clearallnotif()
    {
        $_notif = new Notifications();

        $notif = $_notif->where('recipient', '=', Session::get('user')->user_id)->update(array('isRead' => 1, 'status' => 0));
        return redirect('/notifications');
    }
}

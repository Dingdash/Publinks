<?php

namespace App\Http\Controllers\Follows;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Followers;
use App\User;
use App\Notifications;
use Session;

class FollowController extends Controller
{
    public function index(Request $request, $uID)
    {
        $_followers = new Followers();
        $_user = new User();
        $user = $_user->where('user_id', '=', $uID)->first(['user_id', 'name', 'email', 'about', 'profpic', 'website']);
        $followerid = Session::get('user')->user_id;
        $youraccount = false;
        if ($uID == $followerid) {
            $youraccount = true;
        }
        $follower = $_followers->where('user_id', '=', $uID)->where('follower_id', '=', $followerid)->first(['follower_id']);
        $isfollowing = false;
        if ($follower) {
            $isfollowing = true;
        } else {
            $isfollowing = false;
        }
        //get all followers of the user
        $getfollower = $_followers->where('user_id', '=', $uID)->get(['follower_id']);
        return view('follower')->with(array('list' => $getfollower, 'user' => $user, 'isfollowing' => $isfollowing, 'youraccount' => $youraccount, 'lastsegment' => $uID, 'menu' => 'follower'));
    }
    public function following(Request $request, $uID)
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
        //get all the users following
        $getfollower = $_followers->where('follower_id', '=', $uID)->get(['user_id']);
        return view('follower')->with(array('list' => $getfollower, 'user' => $user, 'isfollowing' => $isfollowing, 'youraccount' => $youraccount, 'lastsegment' => $uID, 'menu' => 'following'));
    }
    public function followuser(Request $request, $uID = "")
    {
        $_followers = new Followers();
        $userid = $uID;
        $followerid = Session::get('user')->user_id;
        if ($request->uID != null) {
            $userid = $request->uID;
        }
        $follower = $_followers->where('user_id', '=', $userid)->where('follower_id', '=', $followerid)->get(['follower_id']);
        if ($request->ajax != "") {

            if ($follower->count() == 0) {

                $userid = $request->uID;
                $_newfollow = new Followers();
                $_newfollow->user_id = $userid; // yang difollow
                $_newfollow->follower_id = $followerid; // yang login
                $_newfollow->save();
                //notification
                $notif = new Notifications();
                $notif->type = 2;
                $notif->author_id = $followerid;
                $notif->recipient = $userid;
                $notif->status = 1;
                $notif->save();
            } else {
            }
            return 'follow success';
        }
        if ($follower->count() == 0) {
            // kalau belum follow
            $_newfollow = new Followers();
            $_newfollow->user_id = $userid; // yang difollow
            $_newfollow->follower_id = $followerid; // yang login
            $_newfollow->save();
            $notif = new Notifications();
            $notif->type = 2;
            $notif->author_id = $followerid;
            $notif->recipient = $userid;
            $notif->status = 1;
            $notif->save();
        }
        return redirect()->back();
    }
    public function unfollowuser(Request $request, $uID = "")
    {
        $_followers = new Followers();
        $userid = $uID;
        $followerid = Session::get('user')->user_id;
        $follower = $_followers->where('user_id', '=', $uID)->get(['follower_id']);
        if ($request->ajax != "") {
            $userid = $request->uID;
            $todelete = $_followers->where('user_id', '=', $userid)->where('follower_id', '=', $followerid);
            $todelete->delete();
            return 'unfollow success';
        }
        if ($follower) {
            $todelete = $_followers->where('user_id', '=', $uID)->where('follower_id', '=', $followerid);
            $todelete->delete();
            return redirect()->back();
            // kalau sudah follow
        }
    }
    //
}

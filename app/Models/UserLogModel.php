<?php

// namespace App\Http\Controllers;
namespace App\Models;

use Illuminate\Http\Request;
use App\Userlog;

class UserLogModel
{
    //
    public function insertlog($user_id, $type, $option = null)
    {
        $text = "";
        switch ($type) {
            case 1: //make transaction
                $text =  "just make a transaction with transaction ID  " . $option;
                break;
            case 2: // registration
                $text =  "just joined to the server";
                break;
            case 3:
                $text =   "just changed password";
                break;
            case 4;
                $text =   "just logged out";
                break;
            case 5:
                $text =    "just logged in";
                break;
            case 6:
                $text =    "just reviewed a book with Book ID  " . $option;
                break;
            default:
                null;
        }
        if ($option) {
            $_userlog = new Userlog();
            $_userlog->text = $text;
            $_userlog->type = $type;
            $_userlog->user_id = $user_id;
            $_userlog->reference_id = $option;
            $_userlog->ip_address = $this->getIP();
            return $_userlog->save();
        } else {
            $_userlog = new Userlog();
            $_userlog->text = $text;
            $_userlog->type = $type;
            $_userlog->user_id = $user_id;
            $_userlog->ip_address = $this->getIP();
            return $_userlog->save();
        }
    }
    // public function getLogBetweenDate($start,$end)
    // {
    //     $_userlog = new Userlog();
    //     $result = $_userlog->whereBetween('created_at',[$start,$end])->get();
    //     return $result;
    // }
    // public function getSingleLog($logid,$userid=null)
    // {
    //     if($userid)
    //     {
    //         $_userlog = new Userlog();
    //         $result = $_userlog->where('user_id',$userid)->where('log_id',$logid)->first();
    //         return $result;

    //     }else{
    //         $_userlog = new Userlog();
    //         $result = $_userlog->where('user_id',$userid)->where('log_id',$logid)->first();
    //         return $result;
    //     }
    // }
    // public function getSingleUser($userid)
    // {
    //     $_userlog = new Userlog();
    //     $result = $_userlog->where('user_id',$userid)->get();
    //     return $result;
    // }
    // public function getByType($type)
    // {
    //     $_userlog = new Userlog();
    //     $result = $_userlog->where('type',$type)->get();
    //     return $result;

    // }
    public function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['eeHTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }
}

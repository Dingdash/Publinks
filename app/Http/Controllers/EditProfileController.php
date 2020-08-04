<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\UserLogModel;
use Session;

class EditProfileController extends Controller
{
    public function editprofileview()
    {
        $edit = new User();
        $user = $edit->where('user_id', '=', Session::get('user')->user_id)->first();
        return view('editprofile', compact('user'));
    }
    public function editprofile(Request $request)
    {
        $name = $request->name;
        $password = $request->password;
        $about = $request->about;
        $website = $request->website;
        $email = $request->email;
        $validator = null;
        $file = $request->file('photo');
        //minta avatar
        if ($file != null) {
            $filename = $request->uID . '-' . time() . '.' . $file->extension();
        }
        if ($password != null) {
            $validator = Validator::make($request->all(), [
                'name'  => 'required|max:64|regex:/^[\pL\s\-]+$/u|string',
                'email' => 'required|unique:users,email,' . $request->uID . ',user_id',
                'password' => 'required|min:6|max:14'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name'  => 'required|max:64|regex:/^[\pL\s\-]+$/u|string',
                'email' => 'required|unique:users,email,' . $request->uID . ',user_id',
            ]);
        }
        if ($validator->fails()) {
            return  redirect()
                ->back()
                ->withErrors($validator->errors());
        } else {
            //berhasil
            $_user = new User();
            $user = $_user->where('user_id', '=', $request->uID)->first();
            $path = null;
            if ($file) {
                $path = $request->file('photo')->storeAs('public/avatars', $filename);
                //proses upload foto
                $user->profpic = 'avatars/' . $filename;
            }
            if ($password != null) {
                $user->password = md5($password);
            }
            $user->name = $name;
            $user->website = $website;
            $user->about = $about;
            $user->email = $email;
            $b = $user->save();
            if ($b == true && $password != null) {
                $_log = new UserLogModel();
                $log = $_log->insertlog($request->uID, 3);
            }
            Session::put('user', $user);
            return redirect()->back()->with(['success' => 'Profile successfully Updated']);
        }
    }
}

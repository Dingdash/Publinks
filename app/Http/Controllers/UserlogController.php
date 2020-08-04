<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLogModel;
use App\Userlog;

class UserlogController extends Controller
{
    public function index(Request $request)
    {
        $userlog = new Userlog();
        if ($request->has('userid')) {
            $userlog = $userlog->where('user_id', $request->input('userid'));
        }
        if ($request->has('sort')) {
            $userlog = $userlog->orderBy('created_at', $request->input('sort'));
        } else {
            $userlog = $userlog->orderBy('created_at', 'DESC');
        }
        if ($request->has('q')) {
            $userlog = $userlog->whereHas('user', function ($query) use ($request) {
                $q = $request->input('q');
                $query->where('username', 'like', $q . '%')->orWhere('name', 'like', $q . '%');
            });
        }
        $userlog = $userlog->paginate(20)->appends([
            'sort' => $request->input('sort'),
        ]);
        return view('admin.userlog', ['userlog' => $userlog]);
    }
}

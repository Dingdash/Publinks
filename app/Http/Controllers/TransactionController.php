<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Session;

class TransactionController extends Controller
{
    public function index()
    {
        $_trans = new Transaction();
        $trans = $_trans->where('user_id', '=', Session::get('user')->user_id)->get();
        return view('transactionhistory', array('transdata' => $trans));
    }
}

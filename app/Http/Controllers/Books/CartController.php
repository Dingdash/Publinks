<?php

namespace App\Http\Controllers\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\ShoppingCart;
use App\Transaction;
use App\Dtrans;
use App\Library;
use Session;
use \XenditClient\XenditPHPClient;

class CartController extends Controller
{
    //
    public function index()
    {
        $_cart = new ShoppingCart();
        $cart = $_cart->where('user_id', '=', Session::get('user')->user_id)->get();
        return view('store.cart', compact('cart'));
    }

    public function addtocart(Request $request, $id)
    {
        $_cart = new ShoppingCart();
        $cart = $_cart->where('product_item', '=', $id)->where('user_id', '=', Session::get('user')->user_id)->first();
        if ($cart == "") {
            $_cart->product_item = $id;
            $_cart->user_id = Session::get("user")->user_id;
            if ($request['free'] == 1) {
                $_cart->price = 0;
            } else {
                $_cart->price = $request['price'];
            }
            // $_cart->price = $request['price'];
            $_cart->save();
        } else {
            // kalau cart sudah ada
            $cart->product_item = $id;
            $cart->user_id = Session::get("user")->user_id;
            if ($request['free'] == 1) {
                $cart->price = 0;
            } else {
                $cart->price = $request['price'];
            }
            $cart->save();
        }
        return redirect()->back()->with('success', 'items added to cart');
    }
    public function deletecart(Request $request, $id)
    {
        $_cart = new ShoppingCart();
        $cart = $_cart->where('id', '=', $id)->first();
        if ($cart->delete()) {
            return redirect()->back();
        }
    }
    public function clearcart($userid)
    {
        $_cart = new ShoppingCart();
        $cart = $_cart->where('user_id', '=', $userid)->delete();
    }
    public function checkout()
    {
        $_cart = new ShoppingCart();
        $cart = $_cart->where('user_id', '=', Session::get('user')->user_id)->get();
        return view('store.checkout', compact('cart'));
    }
    public function savezeroamounttrans(Request $request)
    {
        $_cart = new ShoppingCart();
        $cart = $_cart->where('user_id', '=', Session::get('user')->user_id)->leftjoin('books', 'product_item', '=', 'book_id')->get(['book_id', 'title', 'price']);
        $total = 0;
        foreach ($cart as $c) {
            $total = $total + $c->price;
        }
        if ($total == 0) {
            $_trans  = new Transaction();
            $transactionid = $_trans->getnewkey();
            $_trans->transaction_id = $transactionid;
            $_trans->cart = $cart;
            $_trans->total = 0;
            $_trans->payment_id = $transactionid;
            $_trans->user_id = Session::get('user')->user_id;
            $_trans->save();
            foreach ($cart as $c) {
                $_dtrans = new Dtrans();
                $_dtrans->transaction_id = $transactionid;
                $_dtrans->book_id = $c->book_id;
                $_dtrans->product_item = $c->title;
                $_dtrans->price = $c->price;
                $_dtrans->save();
                $_library = new Library();
                $_library->book_id =  $c->book_id;
                $_library->favorited = 0;
                $_library->user_id = Session::get('user')->user_id;
                $_library->save();
            }
            $this->clearcart(Session::get('user')->user_id);
            return redirect('/');
        }
    }
    public function bayar(Request $request)
    {
        $options['secret_api_key'] = "xnd_development_OYmFfL8k0LSqkcU7KBPSWOSMNTx9NN6l3fpRxnm3UrWhDA51jg";
        $xenditPHPClient = new XenditPHPClient($options);
        $_trans  = new Transaction();
        $external_id = $_trans->getnewkey();
        $token_id = $request->token_id;
        $amount = $request->amount; // Amount must match what was passed to createToken in the browser       
        $response = $xenditPHPClient->captureCreditCardPayment($external_id, $token_id, $amount);
        echo json_encode($response);
    }
    public function savetrans(Request $request)
    {
        echo 'sukses';
        echo $request->id;
        echo $request->q;
        $_cart = new ShoppingCart();
        $cart = $_cart->where('user_id', '=', Session::get('user')->user_id)->leftjoin('books', 'product_item', '=', 'book_id')->get(['book_id', 'title', 'price']);
        $cart = (string)$cart;
        $_trans  = new Transaction();
        $transasctionid = $_trans->getnewkey();
        $_trans->transaction_id = $transasctionid;
        $_trans->cart = $cart;
        $_trans->total = $request->q;
        $_trans->payment_id = $request->id;
        $_trans->user_id = Session::get('user')->user_id;
        $_trans->save();
        $_cart = new ShoppingCart();
        $currentcarts = $_cart->where('user_id', '=', Session::get('user')->user_id)->leftjoin('books', 'product_item', '=', 'book_id')->get(['book_id', 'title', 'price']);
        foreach ($currentcarts as $c) {
            $_dtrans = new Dtrans();
            $_dtrans->transaction_id = $transasctionid;
            $_dtrans->book_id = $c->book_id;
            $_dtrans->product_item = $c->title;
            $_dtrans->price = $c->price;
            $_dtrans->save();
            $_library = new Library();
            $_library->book_id =  $c->book_id;
            $_library->favorited = 0;
            $_library->user_id = Session::get('user')->user_id;
            $_library->save();
        }
        $this->clearcart(Session::get('user')->user_id);
    }
}

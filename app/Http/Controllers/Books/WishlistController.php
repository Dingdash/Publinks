<?php

namespace App\Http\Controllers\Books;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Wishlist;
use Session;
class WishlistController extends Controller
{
    //
    public function index()
    {
        $_wishlist = new Wishlist();
        $wishlist = $_wishlist->where('user_id','=',Session::get('user')->user_id)->get();
        
        return view('store.wishlist',compact('wishlist'));
    }
    public function addtowishlist($item_id)
    {
        $user_id = Session::get('user')->user_id;
        
        $checkwishlist = new Wishlist();
        $checkwishlist = $checkwishlist->where('user_id','=',$user_id)->where('item_id','=',$item_id)->get();
        if (count($checkwishlist)==0) {
            $_wishlist  = new Wishlist();
        $_wishlist->user_id= $user_id;
        $_wishlist->item_id = $item_id;
            if($_wishlist->save())
            {
                return redirect()->back()->with('success','Added to Wishlist');
            }else
            {
                
                return redirect()->back()->with('success','Item already in Wishlist');
            }
            
        } else {
            
            return redirect()->back()->with('success','Item already in Wishlist');
        }
        
    }
    public function removefromwishlist(Request $request,$id)
    {
        $_wishlist = new Wishlist();
        $wishlist = $_wishlist->where('wishlist_id','=',$id)->first();
        if($wishlist)
        {if($wishlist->delete())
        {
        return redirect()->back()->with('success','wishlist removed');
        }}
    }
}

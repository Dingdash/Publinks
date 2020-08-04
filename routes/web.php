<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/Avatar',[
//     'uses'=>'UserController@getUserImage',
//     'as'=>'account.image'
// ]);
use App\User;
use App\Book;


Route::get('/removebookcovers',function(){
$directory= storage_path().'/app/public/bookcovers/';
$directories = Storage::directories($directory);
$images = glob($directory . "*.{jpg,png,gif,jpeg,txt}",GLOB_BRACE);
foreach($images as $image)
{
    $name = explode('/',$image);
    $name = $name[7].'/'.$name[8];
    $first = Book::where('cover','=',$name)->exists();
    if($first)
    {
        
    }else{
        unlink($image);
    }
}

});
Route::get('/removeavatars',function(){
$directory= storage_path().'/app/public/avatars/';
$directories = Storage::directories($directory);
$images = glob($directory . "*.{jpg,png,gif,jpeg}",GLOB_BRACE);
foreach($images as $image)
{
    $name = explode('/',$image);
    $name = $name[7].'/'.$name[8];
    $first = User::where('profpic','=',$name)->exists();
    if($first)
    {
    }else{
        unlink($image);
    }
}
});

Route::group(['middleware'=>'web'],function(){
    Route::get('/', function () {
    return view('welcome');
    
    });
    Route::get('/php',function(){
       phpinfo(); 
    });
    Route::get('/admin','AdminController@login');
    Route::post('/admin','AdminController@login');
        Route::get('/login','LoginController@index');
    Route::post('/login','LoginController@postLogin');
    
    Route::get('/register','RegisterController@index');
    Route::get('/activate','ActivationController@index');
    Route::get('/logout','LoginController@logout');
    Route::post('/logout','LoginController@logout');
    Route::post('/activate','ActivationController@activate');
    Route::post('/register','RegisterController@register');
    Route::get('/resendactivate','ActivationController@resendactivateview');
    Route::get('/forgotpass','ForgotPasswordController@index');
    Route::post('/forgotpass','ForgotPasswordController@forgotpass');
    Route::post('/resendactivate','ActivationController@resendactivate');
});



Route::group(['middleware'=>'usersession'],function(){
    Route::get('/editprofile','EditProfileController@editprofileview');
    Route::post('/editprofile','EditProfileController@editprofile');
    //BOOKS
    Route::get('/createmenu','Books\MakeBookController@index');
    Route::get('/createpdf','Books\MakeBookController@menupdf');
    Route::post('/createpdf','Books\MakeBookController@createnewpdf');
    Route::post('/edittoc','Books\MakeBookController@edittoc');
    Route::get('/editbook/{id}','Books\MakeBookController@editbookinfo');
    Route::post('/editbook','Books\MakeBookController@saveeditbookinfo');
    Route::get('/editbook/stories/{id}','Books\MakeStoryController@liststory');
    Route::get('/read/{id}','Books\LibraryController@open');
    Route::get('/editbook/pdf/{id}','Books\MakeBookController@updatenewpdf');
    Route::post('/editbook/pdf/{id}','Books\MakeBookController@updatenewpdf');
    Route::get('/newstory','Books\MakeStoryController@index');
    Route::get('/newchapter/{id}','Books\MakeStoryController@story');
    Route::get('/editstory/{storyid}','Books\MakeStoryController@editstory');
    Route::post('/newstory','Books\MakeStoryController@newstory');
    Route::post('/savestories',"Books\MakeStoryController@save");
    Route::get('/deletechapter/{id}','Books\MakeStoryController@deletebychapter');
    Route::post('/updatesort','Books\MakeStoryController@updatesort');
    Route::get('/browse','Books\StoreController@index');
    Route::get('/book/{id}','Books\StoreController@showbook');
    
    Route::post('/addtowishlist/{itemid}','Books\WishlistController@addtowishlist');
    Route::get('/avatar/{any}','UserController@getUserImage')->where('any', '.*')->name('account.image');
    Route::get('/bookimage/{any}','Books\MakeBookController@getBookImage')->where('any', '.*')->name('book.image');
    Route::post('/sendemail','AdminController@sendemail');
    Route::get('/u/{userid}','UserController@viewprofile');
    Route::get('/wishlist','Books\WishlistController@index');
    Route::get('/wishlist/remove/{id}','Books\WishlistController@removefromwishlist');
    Route::post('/wishlist/remove/{id}','Books\WishlistController@removefromwishlist');
    Route::get('/cart','Books\CartController@index');
    Route::post('/cart/add/{id}','Books\CartController@addtocart');
    Route::get('/cart/delete/{id}','Books\CartController@deletecart');
    Route::post('/cart/delete/{id}','Books\CartController@deletecart');
    Route::get('/cart/clearcart/{userid}','Books\CartController@clearcart');
    Route::post('/search', 'SearchController@filter');
    Route::get('/search', 'SearchController@filter');
    Route::post('/bayar','Books\CartController@bayar');
    Route::get('/bayar','Books\CartController@bayar');
    Route::post('/savetrans','Books\CartController@savetrans');
    Route::get('/followers/{uID}','Follows\FollowController@index');
    Route::get('/following/{uID}','Follows\FollowController@following');
    Route::get('/followact/{uID}','Follows\FollowController@followuser');
    Route::post('/followact','Follows\FollowController@followuser');
    Route::get('/unfollowact/{uID}','Follows\FollowController@unfollowuser');
    Route::post('/unfollowact','Follows\FollowController@unfollowuser');
    Route::get('/checkout','Books\CartController@checkout');
    Route::get('/library','Books\LibraryController@index');
    Route::post('/addtolib','Books\LibraryController@addtoarchive');
    Route::post('/delfromlib','Books\LibraryController@unarchive');
    Route::get('/review/{bookid}','Books\RateReviewController@getreview');
    Route::post('/review','Books\RateReviewController@review');
    Route::get('/allreview','Books\RateReviewController@allreview');
    Route::get('/allreview/{id}','Books\RateReviewController@viewallreviews');
    Route::get('/singlereview/{bookid}/{id}','Books\RateReviewController@singlereview');
    Route::get('/transhistory','TransactionController@index');
    Route::get('/authorstory','Books\StoryController@index');
    // Route::get('/viewtraffics/','ViewTrafficController@index');
    Route::get('/checkout/pay','Books\CartController@savezeroamounttrans');
    Route::get('/viewtraffics/{id?}','ViewTrafficController@index');
    Route::get('/testraffics','ViewTrafficController@tes');
    Route::get('/ajaxreviews/{bookid}','Books\StoreController@load_morereview');
    Route::get('/ajaxreviews/ratereviewcontroller/{bookid}','Books\RateReviewController@load_morereview');
    Route::post('/replyreview','Books\RateReviewController@replyreview');
    Route::get('/notifications','UserController@viewnotif');
    Route::get('/notifications/delete/{id}','UserController@dismissnotif');
    Route::post('/notifications/delete/{id}','UserController@dismissnotif');
    Route::post('/notifications/markasread/{id}','UserController@markasread');
    Route::post('/notifications/markallasread','UserController@markallasread');
    Route::get('/notifications/markallasread','UserController@markallasread');
    Route::get('/notifications/deleteall','UserController@clearallnotif');
    Route::get('/unreadnotif','UserController@countnewnotif');
    Route::get('/publishing/{bookid}','Books\MakeBookController@publishing');
    Route::post('/publishing','Books\MakeBookController@publishing');
    Route::get('/flagreview/{reviewid}','Books\RateReviewController@flagging');
    Route::post('/flagreview/{reviewid}','Books\RateReviewController@postflagging');
});


//ADMIN ROUTES
Route::post('/resendaktivasi',function(){
    
    $email = Request::get('email');
   
    $code = Request::get('code');
    $name = Request::get('user');
    
    //   Mail::send([],[],function ($message) use($email,$code,$name)  {
            
          

            
    //         $message->from('admin@publ.xyz','PUBLINK')->to($email)->subject("Hello $name")->setBody("Hi Welcome $name")->setBody("  Hello $name<br>
    // your activation code is<b> $code</b><br>
    // continue to 
    // <a href='publ.xyz/activate'>verification.publ.xyz</a>
    // ",'text/html' );
            
    //     });
       return response()->json(['ok' => $email]);
});

Route::group(['middleware'=>'adminsession','web'],function(){
Route::get('/admin/viewtraffics/{id}/{userid}','AdminController@viewtraffics');
Route::get('/admin/favorites','AdminController@favorites');
Route::get('/admin/dashboard','AdminController@index');
Route::get('/admin/edituser/{any}','AdminController@edituser');
Route::post('/admin/edituser/{any}','AdminController@edituser');
Route::get('/admin/users','AdminController@manageuser');
Route::get('/admin/transactions','AdminController@trans');
Route::post('/admin/gettrans','AdminController@gettransbydate');
Route::get('/admin/managebooks','AdminController@getbooks');
Route::post('/admin/deletebook','AdminController@deletebook');
Route::post('/admin/restorebook','AdminController@restorebook');
Route::get('/routes','RouteController@index');
Route::get('/admin/managecategories','AdminController@managecategories');
Route::get('/admin/editcategories/{any}','AdminController@editcategories');
Route::post('/admin/editcategories/{any}','AdminController@editcategories');
Route::post('/admin/category/add','AdminController@addcategory');
Route::get('/admin/category/delete/{id}','AdminController@removecategory');
Route::get('/admin/books/livesearch','AdminController@livesearchbook');
Route::get('/admin/userlog','UserlogController@index');
Route::get('/getbest','AdminController@bestseller');
Route::get('/admin/bestselling','AdminController@bestselling');
Route::get('/adminlogout','AdminController@logout');
Route::get('/admin/bestauthor','AdminController@bestauthor');
Route::get('/admin/flags','AdminController@showflags');
Route::get('/admin/flags/{id}','AdminController@showaflag');
Route::get('/admin/deleteflag/{id}','AdminController@deleteflag');
Route::get('/admin/deletereview/{id}','AdminController@deletereview');
Route::get('/admin/previewbook/{bookid}','AdminController@preview');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

// Route::get('/cobasearch','SearchController@search');
// // Route::get('/tes','Books\StoreController@tes');
// // Route::get('/teschange/{old}/{new}','Books\MakeStoryController@changeposition');
// // Route::get('/tes/{chapterid}','Books\MakeStoryController@readstories');
// Route::get('/loadmore','Books\RateReviewController@tesloadmore');
// Route::get('/tesloadmore','Books\RateReviewController@load_morereview');
// Route::get('/encrypt','encryptController@index');
// Route::get('/tesbaca/{bookid?}/{storyid?}','Books\MakeStoryController@readstories');




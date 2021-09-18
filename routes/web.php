<?php

use Illuminate\Support\Facades\Route;
use App\Models\Notification;

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

//Common
    //notifications
View::composer([
    '*'
    ],function($view){
    $user = Auth::user();
    if($user){
        $notifications = Notification::where('receiver_id',$user->user_id)->where('is_seen',0)->get();
        if($notifications){
            $notifications_count = $notifications->count();
        }else{
            $notifications_count = 0;
        }
        $notification_preview = Notification::where('receiver_id',$user->user_id)->where('is_seen',0)->orderBy('notification_id','desc')->take(5)->get();
        $view->with([
            'notifications'=>$notifications,
            'notifications_count'=>$notifications_count,
            'notification_preview'=>$notification_preview
        ]);
    }
});


Route::get('/', [App\Http\Controllers\Controller::class, 'appIndex']);

Auth::routes();
    //locations - named location search
Route::post('province',[App\Http\Controllers\Controller::class, 'getProvinsi'])->name('province');
Route::post('city',[App\Http\Controllers\Controller::class, 'getKota'])->name('city');
Route::post('district',[App\Http\Controllers\Controller::class, 'getKecamatan'])->name('district');
Route::post('sub_district',[App\Http\Controllers\Controller::class, 'getKelurahan'])->name('sub_district');
Route::post('zip_code',[App\Http\Controllers\Controller::class, 'getKodePos'])->name('zip_code');
Route::post('/populateLocation',[App\Http\Controllers\Controller::class, 'populateLocation'])->name('populateLocation');
Route::get('/home',[App\Http\Controllers\HomeController::class,'homeRedirect'])->name('home.redirect');
Route::get('/customer', [App\Http\Controllers\HomeController::class, 'index'])->name('home.customer')->middleware('auth');
Route::get('/seller', [App\Http\Controllers\HomeController::class, 'sellerIndex'])->name('home.seller')->middleware('auth');
Route::get('/admin', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('home.admin')->middleware('auth');
Route::get('/seller/request', [App\Http\Controllers\HomeController::class, 'sellerRequest'])->name('home.seller.request')->middleware('auth');

//navbar & dashboard sidebar
Route::get('/profile',[App\Http\Controllers\HomeController::class, 'profileIndex'])->name('profile.index')->middleware('auth');
Route::get('/cart',[App\Http\Controllers\HomeController::class, 'cartIndex'])->name('cart.index')->middleware('auth');
Route::get('/products',[App\Http\Controllers\ProductController::class, 'index'])->name('products.index')->middleware('auth');
Route::get('/wishlist',[App\Http\Controllers\HomeController::class, 'wishlistIndex'])->name('wishlist.index')->middleware('auth');
Route::get('/payments',[App\Http\Controllers\TransactionController::class, 'paymentsIndex'])->name('payments.index')->middleware('auth');
Route::get('/shipments',[App\Http\Controllers\HomeController::class,'shipmentsIndex'])->name('shipments.index')->middleware('auth');
Route::get('/deliveries',[App\Http\Controllers\HomeController::class, 'deliveriesIndex'])->name('deliveries.index')->middleware('auth');
Route::get('/transactions',[App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index')->middleware('auth');
Route::get('/message',[App\Http\Controllers\MessageController::class, 'index'])->name('message.all')->middleware('auth');
Route::get('/about',[App\Http\Controllers\Controller::class, 'aboutIndex'])->name('about.index');
Route::get('/user/seller',[App\Http\Controllers\HomeController::class, 'userSellerIndex'])->name('user.seller')->middleware('auth');
Route::get('/user/customer',[App\Http\Controllers\HomeController::class, 'userCustomerIndex'])->name('user.customer')->middleware('auth');
Route::get('/user/admin',[App\Http\Controllers\HomeController::class, 'userAdminIndex'])->name('user.admin')->middleware('auth');

//products
Route::get('/products/add',[App\Http\Controllers\ProductController::class, 'create'])->name('products.create')->middleware('auth');
Route::post('/products/add/store',[App\Http\Controllers\ProductController::class,'store'])->name('products.store')->middleware('auth');
Route::get('/products/{id}/delete',[App\Http\Controllers\ProductController::class,'delete'])->name('products.delete')->middleware('auth');
Route::get('/products/{id}/edit',[App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit')->middleware('auth');
Route::post('/products/{id}/update',[App\Http\Controllers\ProductController::class,'update'])->name('products.update')->middleware('auth');
Route::get('/products/{id}/details',[App\Http\Controllers\ProductController::class, 'details'])->name('products.details')->middleware('auth');
Route::post('products/{id}/quickUpdate',[App\Http\Controllers\ProductController::class, 'quickUpdate'])->name('products.quickUpdate')->middleware('auth');
    //front
Route::get('/products/{id}/wishlist',[App\Http\Controllers\ProductController::class, 'wishlistToggle'])->name('products.wishlistToggle')->middleware('auth');
Route::get('/products/{id}/cart',[App\Http\Controllers\ProductController::class, 'addToCart'])->name('products.addToCart')->middleware('auth');
Route::get('/products/{id}/checkout',[App\Http\Controllers\ProductController::class, 'buyNow'])->name('products.buyNow')->middleware('auth');
Route::get('/products/{id}/payment',[App\Http\Controllers\ProductController::class, 'payment'])->name('products.payment')->middleware('auth');
    //user  
Route::get('/cart/{id}/remove',[App\Http\Controllers\ProductController::class, 'removeFromCart'])->name('products.removeFromCart')->middleware('auth');
Route::get('/wishlist/{id}/remove',[App\Http\Controllers\ProductController::class, 'removeFromWishlist'])->name('products.removeFromWishlist')->middleware('auth');

//Transaction
Route::get('/transactions/payments',[App\Http\Controllers\TransactionController::class, 'paymentsIndex'])->name('transaction.paymentsIndex')->middleware('auth');
Route::get('/transactions/{id}/payment',[App\Http\Controllers\TransactionController::class, 'create'])->name('transaction.create')->middleware('auth');
Route::post('/transactions/{id}/uploadPayment',[App\Http\Controllers\TransactionController::class, 'store'])->name('transaction.store')->middleware('auth');
Route::get('/transactions/{id}/cancel',[App\Http\Controllers\TransactionController::class, 'cancel'])->name('transaction.cancel')->middleware('auth');
Route::get('/transactions/{id}/approve',[App\Http\Controllers\TransactionController::class, 'approve'])->name('transaction.approve')->middleware('auth');
Route::get('/transactions/{id}/reject',[App\Http\Controllers\TransactionController::class, 'reject'])->name('transaction.reject')->middleware('auth');
Route::get('/transactions/{id}/done',[App\Http\Controllers\TransactionController::class, 'done'])->name('transaction.done')->middleware('auth');
Route::get('/transactions/{id}/received',[App\Http\Controllers\TransactionController::class, 'received'])->name('transaction.received')->middleware('auth');
Route::get('/transactions/{id}/send',[App\Http\Controllers\TransactionController::class, 'send'])->name('transaction.send')->middleware('auth');

//gallery
Route::get('/products/{id}/gallery',[App\Http\Controllers\GalleryController::class,'index'])->name('gallery.index')->middleware('auth');
Route::get('/products/{id}/show-gallery',[App\Http\Controllers\GalleryController::class, 'showGallery'])->name('gallery.showGallery');
Route::post('/products/{id}/gallery/add',[App\Http\Controllers\GalleryController::class, 'store'])->name('gallery.store')->middleware('auth');
Route::post('/products/{id}/gallery/delete',[App\Http\Controllers\GalleryController::class, 'destroy'])->name('gallery.destroy')->middleware('auth');

//message //front
Route::get('/message/{room_number}',[App\Http\Controllers\MessageController::class,'index'])->name('message.index')->middleware('auth');
Route::post('/message/store',[App\Http\Controllers\MessageController::class,'store'])->name('message.store')->middleware('auth');
Route::get('/message/{id}/product',[App\Http\Controllers\MessageController::class,'indexProduct'])->name('message.indexProduct')->middleware('auth');
Route::get('/messag/{id}',[App\Http\Controllers\MessageController::class,'indexTransaction'])->name('message.indexTransaction')->middleware('auth');


//front
Route::get('/profile/{id}',[App\Http\Controllers\ProfileController::class,'view'])->name('profile.view');
Route::get('/categories/{req}',[App\Http\Controllers\FrontController::class, 'categoriesIndex'])->name('front.categories');
Route::get('/products/{req}',[App\Http\Controllers\ProductController::class, 'frontIndex'])->name('front.product.index');
Route::get('/products/detail/{id}',[App\Http\Controllers\FrontController::class, 'productDetails'])->name('front.product.details');

//user
Route::get('/user/{id}/activation',[App\Http\Controllers\ProfileController::class, 'activation'])->name('profile.delete')->middleware('auth');
Route::get('/user/{id}/approve',[App\Http\Controllers\ProfileController::class,'approveSellerRequest'])->name('profile.approveSellerRequest')->middleware('auth');
Route::post('/user/{id}/update',[App\Http\Controllers\ProfileController::class,'update'])->name('profile.update')->middleware('auth');
Route::post('/user/{id}/picture',[App\Http\Controllers\ProfileController::class,'changePicture'])->name('profile.changePicture')->middleware('auth');

//delivery
Route::post('/delivery/{id}/store',[App\Http\Controllers\DeliveryController::class, 'store'])->name('delivery.store')->middleware('auth');
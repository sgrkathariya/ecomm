<?php

use App\Http\Controllers\Backend\BrandController;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

Route::get('/', 'FrontendController@index')->name('home');

Auth::routes(['verify' => true]);

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('login.social');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('login.social.callback');

Route::get('system-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')
    ->name('system.logs')
    ->middleware('role:super-admin');

// User Account overview (only for mobile)
Route::get('/user/account', 'UserAccountController@index')->name('frontend.user.account.index');

// Profile routes
Route::get('profile', 'UserController@profile')->name('user.profile');
Route::put('profile/update/{user}', 'UserController@updateProfile')->name('user.profile.update');

// Product routes
Route::get('products', 'ProductController@index')->name('frontend.products.index');
Route::get('p/{tag}', 'ProductController@byGroup')->name('frontend.products.by-group');
Route::get('products/{product}', 'ProductController@show')->name('frontend.products.show');

// Passworc change routes
Route::get('change-password', 'PasswordController@index')->name('frontend.password.index');
Route::patch('change-password', 'PasswordController@update')->name('frontend.password.update');

Route::get('/cart', 'CartController@index')->name('frontend.cart.index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('wishlists', 'WishlistController@index')->name('frontend.wishlists.index');
    Route::delete('wishlist/{wishlist}', 'WishlistController@destroy')->name('frontend.wishlists.destroy');
});

Route::get('checkout', 'CheckoutController@index')->name('frontend.checkout.index');
Route::post('apply-coupon', 'CheckoutController@applyCoupon')->name('apply-coupon');

// Route::get('paypal/express-checkout/{order}', 'PaypalController@expressCheckout')->name('paypal.express-checkout');
// Route::get('paypal/express-checkout-success', 'PaypalController@expressCheckoutSuccess')->name('paypal.express-checkout.success');
// Route::get('paypal/express-checkout-cancel', 'PaypalController@expressCheckoutCancel')->name('paypal.express-checkout.cancel');

Route::get('dicount-card', 'DiscountCardController@index')->name('frontend.discount-card.index');

// Orders route
Route::get('orders', 'OrderController@index')->name('frontend.orders.index');
Route::post('orders', 'OrderController@store')->name('frontend.orders.store');

Route::get('my-reviews', 'MyReviewController')->name('frontend.my-reviews')->middleware('auth');

Route::view('contact-form', 'frontend.contact-form.index')->name('frontend.contact-form.index');

// Blogs
Route::get('blogs', 'BlogController@index')->name('frontend.blogs.index');
Route::get('blogs/{post}', 'BlogController@show')->name('frontend.blogs.show');

Route::get('page/{page}', 'PageController@show')->name('frontend.pages.show');

// Can clear those
Route::get('cart-destroy', function () {
    return Cart::destroy();
});

Route::get('paypal-pay/{order}', 'PaymentController@pay')->name('paypal.pay');
Route::get('paypal-success', 'PaymentController@success')->name('paypal.success');
Route::get('paypal-cancelled', 'PaymentController@cancelled')->name('paypal.cancelled');



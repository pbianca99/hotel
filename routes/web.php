<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Frontend\FrontendRoomController;
use App\Http\Controllers\Frontend\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/',[UserController::class, 'Index']);

Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/profile/store', [UserController::class, 'UserStore'])->name('profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/password/change/password', [UserController::class, 'ChangePasswordStore'])->name('password.change.store');
});

require __DIR__.'/auth.php';


Route::middleware(['auth','roles:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
});

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

Route::middleware(['auth','roles:admin'])->group(function(){

    Route::controller(EmployeeController::class)->group(function(){
        Route::get('/all/employees', 'AllEmployees')->name('all.employees');
        Route::get('/add/employee', 'AddEmployee')->name('add.employee');
        Route::post('/team/store','StoreTeam')->name('team.store');
        Route::get('/edit/employee/{id}', 'EditEmployee')->name('edit.employee');
        Route::post('/team/update','UpdateTeam')->name('team.update');
        Route::get('/delete/employee/{id}', 'DeleteEmployee')->name('delete.employee');
    });

    Route::controller(BannerController::class)->group(function(){
        Route::get('/banner/details', 'DetailsBanner')->name('banner.details');
        Route::post('/banner/update', 'UpdateBanner')->name('banner.update');
    });

    Route::controller(RoomTypeController::class)->group(function(){
        Route::get('/room/type/list', 'RoomTypeList')->name('room.type.list');
        Route::get('add/room/type', 'AddRoomType')->name('add.room.type');
        Route::post('/room/type/store', 'RoomTypeStore')->name('room.type.store');
    });


    Route::controller(RoomController::class)->group(function(){
        Route::get('/edit/room/{id}', 'EditRoom')->name('edit.room');
        Route::post('/update/room/{id}', 'UpdateRoom')->name('update.room');
        Route::get('/delete/room/{id}', 'DeleteRoom')->name('delete.room');
        Route::get('/multi/image/delete/{id}', 'MultiImageDelete')->name('multi.image.delete');
        Route::post('/store/room/no/{id}', 'StoreRoomNumber')->name('store.room.number');
        Route::get('/edit/roomno/{id}','EditRoomNumber')->name('edit.roomno');
        Route::post('/update/roomno/{id}','UpdateRoomNumber')->name('update.roomno');
        Route::get('/delete/roomno/{id}', 'DeleteRoomNumber')->name('delete.roomno');
    });

});

Route::controller(FrontendRoomController::class)->group(function(){
    Route::get('/rooms/','AllFrontendRoomList')->name('froom.all');
    Route::get('/room/details/{id}','RoomDetailsPage');
    Route::get('/bookings/','BookingSearch')->name('booking.search');
    Route::get('/search/room/details/{id}','SearchRoomDetails')->name('search_room_details');

    Route::get('/check_room_availability','CheckRoomAvailability')->name('check_room_availability');
});

//user must be logged in to access this route
Route::middleware(['auth'])->group(function(){
    Route::controller(BookingController::class)->group(function(){
        Route::get('/checkout/','Checkout')->name('checkout');
        Route::post('/booking/store/','BookingStore')->name('user_booking_store');
        Route::post('/checkout/store/','CheckoutStore')->name('checkout.store');
        Route::match(['get', 'post'],'/stripe_pay', [BookingController::class, 'stripe_pay'])->name('stripe_pay');

    });
});


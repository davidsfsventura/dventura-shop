<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', [Controller::class, 'main']);
Route::get('/about', [Controller::class, 'about']);
Route::get('/shop', [Controller::class, 'shop']);
Route::get('/feedback', [Controller::class, 'feedback']);
Route::post('/feedback/sendfeedback', [EmailController::class, 'sendfeedback']);
Route::get('/feedback/sendfeedback', [EmailController::class, 'GoToFeedback']);
Route::get('/login', [Controller::class, 'loginForm'])->name('login');
Route::get('/resetcode', [Controller::class, 'resetCodeForm'])->middleware('guest');
Route::get('/accountinfo', [Controller::class, 'accountinfo'])->middleware('auth');
Route::get('/users/authenticate', [UserController::class, 'goToLogin']);
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
Route::get('users/register', [UserController::class, 'goToRegister']);
Route::post('users/register', [UserController::class, 'register']);
Route::get('/users/profilepicture', [ProfileController::class, 'goToLogin']);
Route::post('/users/profilepicture', [ProfileController::class, 'profilepic']);
Route::get('/users/logout', [UserController::class, 'logout'])->middleware('auth');
Route::get('/register', [Controller::class, 'registerform'])->middleware('guest');
Route::get('/resetpassword', [Controller::class, 'resetPassForm']);
Route::get('/users/resetpass', [UserController::class, 'goToResetPass']);
Route::post('/users/resetpass', [UserController::class, 'resetpass']);
Route::get('/users/changeemail', [ProfileController::class, 'goToLogin']);
Route::post('/users/changeemail', [ProfileController::class, 'changeprofileEmail'])->middleware('auth');
Route::get('/users/changeusername', [ProfileController::class, 'goToLogin']);
Route::post('/users/changeusername', [ProfileController::class, 'changeprofileusername'])->middleware('auth');
Route::get('/users/changepassword', [ProfileController::class, 'goToLogin']);
Route::post('/users/changepassword', [ProfileController::class, 'changeprofilepassword'])->middleware('auth');
Route::post('/users/deleteaccount', [ProfileController::class, 'deleteaccount'])->middleware('auth');
Route::get('/users/deleteaccount', [ProfileController::class, 'goToLogin']);
Route::get('/users/resetcode', [UserController::class, 'goToCodeReset']);
Route::post('/users/resetcode', [EmailController::class, 'newCode']);
Route::get('/users/verifyaccount', [EmailController::class, 'verifyEmail']);
Route::get('/users/verify/{email}', [UserController::class, 'completeVerification'])->name('verifyaccount')->middleware('signed');
Route::get('/users/activate2fa', [UserController::class, 'activate2fa']);
Route::get('/users/send2fa', [EmailController::class, 'send2fa']);
Route::get('/users/authenticate/2facodeForm', [Controller::class, 'verify2FA']);
Route::get('/users/authenticate/2facodeForm/{email}', [Controller::class, 'show2faForm'])->name('2factor')->middleware('signed');
Route::get('/users/authenticate/verify2facode', [UserController::class, 'goTologin']);
Route::post('/users/authenticate/verify2facode', [UserController::class, 'verify2facode']);
Route::get('/users/delete2fa', [UserController::class, 'goToLogin']);
Route::post('/users/delete2fa', [UserController::class, 'disable2fa']);
Route::post('/shop/add_to_cart', [CartController::class, 'AddToCart']);
Route::get('/shop/cart', [Controller::class, 'showCartForm']);

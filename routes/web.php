<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Add ['verify' => true] when the application uses the email verification of
// Laravel: the 'verify' view of this package posts to the 'verification.resend'
// route, which 'Auth::routes()' only registers with that option.

Auth::routes();

// Auth::routes() only registers logout as a POST route (used by the sidebar
// user menu's logout form). This adds a GET variant for direct navigation.
// It stays outside the 'auth' group below since Auth::logout() no-ops
// harmlessly for a guest.

Route::get('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout.get');

// Every page of the dashboard requires an authenticated session. Login,
// register and password-reset (registered above by Auth::routes()) are the
// only routes reachable while logged out; a guest hitting anything in this
// group is redirected to the login screen. Add every new app route here.

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

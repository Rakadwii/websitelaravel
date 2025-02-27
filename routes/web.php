<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagementUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Frontend\HomeController;

// Acara 3
Route::get('/index', function () {
    return view('welcome');
});
Route::get('/user', [UserController::class, 'index']);

Route::any('/', function () {
    return 'ini any';
});

Route::redirect('/here', '/there', 301);
Route::view('/welcome2', 'welcome');
Route::view('/welcome3', 'welcome')->name('Taylor');

Route::get('user/acara3/{name?}', function ($name = "John") {
    return $name;
})->where('name', '[A-Za-z]+');

Route::get('user/{id}', function ($id) {
    return $id;
})->where('id', '[0-9]+');

Route::get('user/{id}/{name}', function ($id, $name) {
    return "User ID: $id, Username: $name";
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

Route::get('search/{search}', function ($search) {
    return $search;
})->where('search', '.*');

// Acara 4
Route::get('/user/{id}/profile', function ($id) {
    return "Profil user dengan ID $id";
})->name('profile');

Route::get('/generate-url', function () {
    $url = route('profile', ['id' => 5]);
    return "URL ke profile: $url";
});

Route::get('/redirect-profile', function () {
    return redirect()->route('profile', ['id' => 5]);
});

Route::middleware(['first', 'second'])->group(function () {
    Route::get('/first', function () {});
    Route::get('/user/profile', function () {});
});

Route::domain('{account}.myapp.com')->group(function () {
    Route::get('user/{id}', function ($account, $id) {
        return "Akun: $account, ID: $id";
    });
});

Route::prefix('admin')->group(function () {
    Route::get('users', function () {});
});

Route::name('admin.')->group(function () {
    Route::get('users', function () {})->name('users');
});


//Acara 5
Route::get('user', [ManagementUserController::class, 'index']);
Route::get('user/create', [ManagementUserController::class, 'create']);
Route::post('user', [ManagementUserController::class, 'store']);
Route::get('user/{id}', [ManagementUserController::class, 'show']);
Route::get('user/{id}/edit', [ManagementUserController::class, 'edit']);
Route::put('user/{id}', [ManagementUserController::class, 'update']);
Route::delete('user/{id}', [ManagementUserController::class, 'destroy']);

//Acara 6
Route::get('/home', [ManagementUserController::class, 'index']);

//Acara 7
Route::resource('/homeacara7', HomeController::class);

//Acara 8
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('product', ProductController::class);
});
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageuserController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|r
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('guest')->group(
    function () {
        Route::controller(AuthController::class)->prefix('auth')->group(function () {
            Route::get('/login', function () {
                return view('pages.auth.login');
            })->name('login');
            Route::get('/register', function () {
                return view('pages.auth.register');
            })->name('register');
            Route::post('/login', 'loginProcess')->name('loginProcess');
            Route::post('/register', 'registerProcess')->name('registerProcess');
        });
    }
);

Route::middleware('auth')->group(
    function () {
        Route::controller(AuthController::class)->prefix('auth')->group(function () {

            Route::get('/logout', 'logout')->name('logout');
            Route::post('/update', 'updateUser')->name('updateUser');
            Route::post('/delete/{id}', 'deleteUser')->name('deleteUser');
        });
        Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
            Route::get('/', 'dashboard')->name('dashboard');
        });
        Route::controller(SettingController::class)->prefix('setting')->group(
            function () {
                Route::get('/', 'index')->name('setting');
            }
        );


        Route::controller(ManageuserController::class)->prefix('manageuser')->group(
            function () {
                Route::get('/', 'index')->name('manageuser');
                Route::post('/update', 'ismasuk')->name('manageuserupdate');
                Route::get('/edit/{user}', 'edit')->name('manageuseredit');
                Route::put('/update/{user}', 'update')->name('manageusereditupdate');
                Route::delete('/delete/{id}', 'deleteuser')->name('manageuserdelete');
            }

        );
    }
);

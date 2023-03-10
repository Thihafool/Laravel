<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('create');
// });
Route::redirect('/', 'customer/createPage')->name('post#home');

// Route::get('/', [PostController::class, 'create'])->name('post#home');
Route::get('customer/createPage', [PostController::class, 'create'])->name('post#createPage');
Route::post('post/create', [PostController::class, 'postCreate'])->name('post#create');

Route::get('testing', function () {
    return "this is testing...";
})->name('test');

Route::get('post/delete/{id}', [PostController::class, 'postDelete'])->name('post#delete');
// Route::delete('post/delete/{id}', [PostController::class, 'postDelete'])->name('post#delete');

Route::get('post/updatePage/{id}', [PostController::class, 'updatePage'])->name('post#updatepage');
Route::get('post/editPage/{id}', [PostController::class, 'editPage'])->name('edit#page');
Route::post('post/Update/{id}', [PostController::class, 'update'])->name('post#update');
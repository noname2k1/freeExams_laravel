<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function (Request $request) {
    $posts = Post::all();
    return view('home', compact('posts'));
})->name('home');
Route::get('/about', function (Request $request) {
    $posts = Post::all();
    return view('about', compact('posts'));
})->name('about');
Route::get('/history', function (Request $request) {
    $posts = Post::all();
    return view('history', compact('posts'));
})->name('history');

Route::resource('/posts', PostController::class);
Route::resource('/exams', ExamController::class);
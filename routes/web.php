<?php

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

Auth::routes();

Route::get('/', [App\Http\Controllers\QuizHomeController::class, 'index'])->name('index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::group(['prefix' => 'questions'], function () {
    Route::get('/create', [App\Http\Controllers\QuestionsController::class, 'index'])->name('index');
    Route::get('/view', [App\Http\Controllers\QuestionsController::class, 'view'])->name('view');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/list', [App\Http\Controllers\UserListController::class, 'list'])->name('list');
});

Route::group(['prefix' => 'quiz'], function () {
    Route::get('/create', [App\Http\Controllers\QuizController::class, 'index'])->name('index');
    Route::get('/view', [App\Http\Controllers\QuizController::class, 'view'])->name('view');
    Route::get('/active', [App\Http\Controllers\Api\QuizController::class, 'active'])->name('active');
    Route::get('/play/{quiz}', [App\Http\Controllers\QuizHomeController::class, 'play'])->name('play');
    Route::get('/play/question/{question}', [App\Http\Controllers\Api\QuestionController::class, 'show'])->name('show');
    Route::post('/user/store', [App\Http\Controllers\Api\QuizUserController::class, 'store'])->name('store');
    Route::post('/user/answer/store', [App\Http\Controllers\Api\QuizUserAnswerController::class, 'store'])->name('store');
    Route::get('/question/{quiz_id}', [App\Http\Controllers\Api\QuizController::class, 'questions'])->name('questions');
    Route::post('/user/{quiz_user_id}', [App\Http\Controllers\Api\QuizUserController::class, 'compelete'])->name('compelete');
});
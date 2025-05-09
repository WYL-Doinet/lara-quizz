<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/sign-in', [AuthController::class, 'signIn'])->name('auth.signIn')->middleware('guest');
Route::post('/sign-in', [AuthController::class, 'signIn'])->name('auth.signIn')->middleware('guest');

Route::get('/login', function () {
    return redirect('/sign-in');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');

    Route::get('/', HomeController::class)->name('home');
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/sign-out', [AuthController::class, 'signOut'])->name('auth.signOut');
    Route::match(['GET', 'POST'], '/quizzes/{id}/assign', [QuizController::class, 'assign'])->name('quiz.assign');
    Route::get('/quizzes/attempts', [QuizController::class, 'attempt'])->name('quiz.attempt');
    Route::get('/quizzes/{id}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quizzes/{id}/answer', [QuizController::class, 'answer'])->name('quiz.answer');
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quiz.index');
});

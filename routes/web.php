<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

// SignIn Form
// SignIn Form
Route::get('/signIn', [RecipeController::class, 'signIn'])->name('signIn');
Route::post('/signIn', [RecipeController::class, 'signInPost'])->name('signInPost');


//SignUp Form
Route::get('/signUp', [RecipeController::class, 'signUp'])->name('signUp');
Route::post('/signUp', [RecipeController::class, 'signUpPost'])->name('signUpPost');

// หน้า RECIPE)
Route::get('/', [RecipeController::class, 'recipe'])->name('home');
Route::get('/recipe', [RecipeController::class, 'recipe'])->name('recipe');

// logout
Route::post('/logout', [RecipeController::class, 'logout'])->name('logout');
<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

// SignIn Form
Route::get('/signIn',[RecipeController::class,'signIn'])->name('signIn');

//SignUp Form
Route::get('/signUp',[RecipeController::class,'signUp'])->name('signUp');

// หน้า RECIPE
Route::get('/recipe',[RecipeController::class,'recipe'])->name('recipe');
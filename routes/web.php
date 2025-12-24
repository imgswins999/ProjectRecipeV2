<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\PopularController;
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
Route::get('/recipe/{recipe_id}', [RecipeController::class, 'detailfood'])->name('recipe.detail');

// logout
Route::post('/logout', [RecipeController::class, 'logout'])->name('logout');

//Like                                                                              
Route::post('/recipe/{recipe_id}/like', [RecipeController::class, 'like'])->name('like');

// comment
// Route สำหรับบันทึกคอมเมนต์ (ใช้ได้ทั้งคอมเมนต์หลักและตอบกลับ)
Route::post('/comment/{recipe_id}', [App\Http\Controllers\RecipeController::class, 'storeComment'])->name('comment.store');


//ค้นหาสูตรอาหาร
Route::get('/search', [RecipeController::class, 'serchRecipe'])->name('search');


//popular
Route::get('/popular', [PopularController::class, 'view_popular'])->name('popular');

// Route::get('/category', [CategoryController::class, 'CategoryFilter'])->name('categoryfilter');
// Route::get('/category/region', [CategoryController::class, 'RegionFilter'])->name('RegionFilter');


Route::get('/category', [CategoryController::class, 'search'])->name('category');
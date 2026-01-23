<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InsertRecipeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\PopularController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\UpdateProfileController;
use App\Http\Controllers\UserProfileController;
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

// Category
Route::get('/category', [CategoryController::class, 'search'])->name('category');

// Writing View Page
Route::get('/writingView', [InsertRecipeController::class, 'writingView'])->name('writingView');

Route::post('/edit/{recipe_id}',[EditController::class,'editView'])->name('edit');

// ลบสองบรรทัดสุดท้ายของเดิมออก แล้วเปลี่ยนเป็นบรรทัดนี้บรรทัดเดียว
Route::post('/recipes/save', [InsertRecipeController::class, 'store'])->name('recipes.store');
Route::post('/recipe/update/{id}', [EditController::class, 'update'])->name('recipes.update'); // ชื่อ update สำหรับบันทึก
Route::post('/delete/{recipe_id}',[DeleteController::class,'delete'])->name('delete');
// profile
// ตัวอย่างการตั้งชื่อใน web.php
Route::get('/profile/{id}', [ProfileController::class,'profile'])->name('profile.show');
// update profile
// ในไฟล์ routes/web.php
Route::post('/profile/update', [UpdateProfileController::class, 'updateProfile'])->name('update.profile')->middleware('auth');
// user profile
Route::get('/user/{id}', [UserProfileController::class, 'showUserProfile'])->name('user.profile');
// follows
Route::middleware(['auth'])->group(function () {
    Route::post('/follow/{user_id}', [FollowController::class, 'toggleFollow'])->name('follow.toggle');
});
// history
Route::get('/my-history', [HistoryController::class, 'history'])->name('history.index')->middleware('auth');
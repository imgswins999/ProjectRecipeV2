<?php

namespace App\Http\Controllers;
use App\Models\RecipeModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class ProfileController extends Controller
{
    //
    public function profile($id)
    {

        $recipes = RecipeModel::with('user')
            ->withCount('likers')
            ->get();
        // ดึงข้อมูล User พร้อมนับจำนวน Follower/Following
        $user = User::withCount(['followers', 'followings'])->findOrFail($id);
        // ดึงสูตรอาหารที่ User นี้เป็นคนเขียน (is_hidden = 0)
        $recipe = $user->recipes()->where('is_hidden', 0)->latest()->get();
        // ดึงเมนูที่ User นี้ไปกด Like ไว้
        $likedRecipe = $user->likes()->get();
        return view('users.profile', compact('user', 'recipe', 'likedRecipe', 'recipes'));
    }
}

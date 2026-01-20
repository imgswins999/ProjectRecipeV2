<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // <--- 1. เพิ่มบรรทัดนี้ เพื่อเรียกใช้ DB::table
use App\Models\Comment;
use App\Models\User;
use App\Models\RecipeModel; // <--- คุณ Import ชื่อนี้ไว้
use App\Models\Like;
use App\Models\RecipeView;
use Carbon\Carbon;


class UserProfileController extends Controller
{
    //
    public function showUserProfile($id)
    {
        $user = User::findOrFail($id); // หา user เจ้าของโปรไฟล์

        // ดึงสูตรอาหารของ user คนนี้
       $recipes = RecipeModel::where('user_id', $id)
            ->withCount('likes') // <--- สั่งให้นับจำนวนไลค์เก็บไว้ในตัวแปร likes_count
            ->latest()
            ->get();

        // นับจำนวนต่างๆ
        $recipeCount = $recipes->count(); // จำนวนงานเขียน (Compositions)
        $followerCount = DB::table('follows')->where('following_id', $id)->count(); // คนติดตาม (Follower)

        // นับยอดไลก์รวมที่ user คนนี้ได้รับจากทุกสูตร
        // (ต้อง Join ตาราง recipes กับ likes)
        $totalLikes = DB::table('likes')
            ->join('recipes', 'likes.recipe_id', '=', 'recipes.recipe_id')
            ->where('recipes.user_id', $id)
            ->count();

        // เช็คว่าเรากดติดตามเขาหรือยัง (สำหรับปุ่ม Follow)
        $isFollowing = false;
        if (Auth::check()) {
            $isFollowing = DB::table('follows')
                ->where('follower_id', Auth::id())
                ->where('following_id', $id)
                ->exists();
        }

        return view('users.userProfile', compact('user', 'recipes', 'recipeCount', 'followerCount', 'totalLikes', 'isFollowing'));
    }
}

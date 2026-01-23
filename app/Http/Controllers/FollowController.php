<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Comment; // อย่าลืม use Model
use App\Models\User;
use App\Models\RecipeModel;
use App\Models\Like;
use App\Models\RecipeView;
use Carbon\Carbon; //ใช้กำหนดเวลา

class FollowController extends Controller
{
    //
    public function toggleFollow(Request $request, $target_user_id)
    {
        $currentUser = Auth::user(); // ผู้ใช้ที่ล็อกอินอยู่
        $targetUser = User::findOrFail($target_user_id); // เชฟที่ต้องการติดตาม

        // ห้ามติดตามตัวเอง
        if ($currentUser->user_id === $targetUser->user_id) {
            return response()->json(['message' => 'ไม่สามารถติดตามตัวเองได้'], 400);
        }

        if ($currentUser->isFollowing($targetUser)) {
            // ถ้าติดตามอยู่แล้ว ให้กดยกเลิก
            $currentUser->unfollow($targetUser);
            $status = 'unfollowed';
        } else {
            // ถ้ายังไม่ติดตาม ให้กดติดตาม
            $currentUser->follow($targetUser);
            $status = 'followed';
        }

        return redirect()->back()->with('success', 'ติดตามแล้ว');
    }
}

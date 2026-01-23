<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RecipeModel;


class HistoryController extends Controller
{
    //
    public function history()
    {
        // ดึงประวัติเฉพาะของ User ที่ Login อยู่ และเรียงจากที่เพิ่งดูไปล่าสุด
        if (!Auth::check()) {
            return redirect()->route('signIn');
        }

        // ดึงประวัติพร้อมข้อมูลสูตรอาหาร เรียงจากดูลาสุด
        $histories = History::with('recipe.user')
            ->where('user_id', Auth::id())
            ->orderBy('viewed_at', 'desc')
            ->get();

        

        return view('users.history', compact('histories'));
    }
}

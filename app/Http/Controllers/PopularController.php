<?php

namespace App\Http\Controllers;
use App\Models\RecipeModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PopularController extends Controller
{
    //
    public function view_popular(Request $request)
    {
       $filter = $request->get('filter', 'all-time');
        $now = Carbon::now();
        $recipesQuery = RecipeModel::query(); 

        // 1. กำหนดช่วงเวลาเริ่มต้น (Start Date) โดยใช้ copy() เพื่อความปลอดภัย
        if ($filter === 'day') {
            $startDate = $now->copy()->startOfDay();
        } elseif ($filter === 'month') {
            $startDate = $now->copy()->startOfMonth();
        } elseif ($filter === 'year') {
            $startDate = $now->copy()->startOfYear();
        }

        // 2. สร้าง Query: นับยอดวิวตามช่วงเวลาที่เลือก
        if (isset($startDate)) {
            $recipesQuery->withCount(['views' => function ($query) use ($startDate, $now) {
                // กรองตาราง recipe_views ที่ viewed_at อยู่ในช่วงเวลานั้นๆ
                $query->whereBetween('viewed_at', [$startDate, $now]);
            }])
            // จัดเรียงตาม views_count ที่ถูกคำนวณ
            ->orderByDesc('views_count');
           
            
        } else {
            // All-time: จัดเรียงตามคอลัมน์ view_count สะสม
            $recipesQuery->orderBy('view_count', 'desc');
        }

        // 3. ดึงข้อมูลพร้อม Pagination
        $popularRecipes = $recipesQuery
            ->with('user')
            ->paginate(10); 

        return view('users.popular', [
            'popularRecipes' => $popularRecipes,
            'currentFilter' => $filter,
            'title' => 'สูตรอาหารยอดนิยม'
        ]);
    }
}

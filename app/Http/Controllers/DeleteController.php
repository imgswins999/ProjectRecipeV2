<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    public function delete($recipe_id)
    {
        // ใช้ Transaction เพื่อความปลอดภัย หากตัวใดตัวหนึ่งลบพลาด ระบบจะยกเลิกทั้งหมด
        DB::transaction(function () use ($recipe_id) {
            // 1. ลบข้อมูลจากตารางที่ไม่มี ON DELETE CASCADE ก่อน
            DB::table('recipe_tags')->where('recipe_id', $recipe_id)->delete();
            DB::table('recipe_views')->where('recipe_id', $recipe_id)->delete();
            DB::table('viewhistory')->where('recipe_id', $recipe_id)->delete();
            
            // หมายเหตุ: recipe_ingredients ไม่ต้องลบเองเพราะมี CASCADE ใน SQL แล้ว

            // 2. ลบข้อมูลจากตารางหลัก
            DB::table('recipes')->where('recipe_id', $recipe_id)->delete();
        });

        return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จแล้ว');
    }
}
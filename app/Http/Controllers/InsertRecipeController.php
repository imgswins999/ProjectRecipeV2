<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   // สำคัญ: ต้องมีเพื่อใช้คำสั่งฐานข้อมูล
use Illuminate\Support\Facades\Auth; // สำคัญ: ต้องมีเพื่อใช้ดึง ID ผู้ใช้
use Illuminate\Support\Facades\Storage; // เพิ่มเพื่อใช้จัดการไฟล์

class InsertRecipeController extends Controller
{
    //
    public function writingView()
    {
        $categories = DB::table('category')->get();
        $regions = DB::table('region')->get();

        // ส่งข้อมูลไปที่ view
        return view('users.writing', compact('categories', 'regions'));
    }

    public function store(Request $request)
    {

        return DB::transaction(function () use ($request) {
            // --- ส่วนจัดการไฟล์รูปภาพ ---
            $imageLink = null;

            if ($request->hasFile('image')) {
                // 1. เก็บไฟล์ลงใน storage
                $path = $request->file('image')->store('recipes', 'public');

                // 2. แปลงเป็นลิงก์เต็มๆ (เช่น http://localhost:8000/storage/recipes/xxx.jpg)
                // แล้วบันทึกลิงก์นี้ลงฐานข้อมูล
                $image_url = asset('storage/' . $path);
            }
            // บันทึกลงตาราง recipes
            $recipe_id = DB::table('recipes')->insertGetId([
                'user_id' => auth()->id(),
                'title' => $request->title,
               'image_url' => $image_url, // ตอนนี้ค่าใน DB จะเป็นลิงก์เต็มๆ แล้ว // บันทึกตัวแปรที่เป็นลิงก์ลงไปเลย
                'description' => $request->description,
                'instructions' => $request->instructions,
                'category_id' => $request->category_id,
                'region_id' => $request->region_id,
                'ingredients' => '', // กัน Error NOT NULL ใน SQL
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // บันทึกลงตาราง recipe_ingredients
            $ingredients = json_decode($request->ingredients_json, true);
            foreach ($ingredients as $ing) {
                DB::table('recipe_ingredients')->insert([
                    'recipe_id' => $recipe_id,
                    'ingredient_name' => $ing['name'],
                    'amount' => $ing['amount'],
                    'unit' => $ing['unit']
                ]);
            }
            return response()->json(['success' => true]);
        });
    }

}

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RecipeModel;
use Illuminate\Support\Facades\DB;   // สำคัญ: ต้องมีเพื่อใช้คำสั่งฐานข้อมูล
use Illuminate\Support\Facades\Auth; // สำคัญ: ต้องมีเพื่อใช้ดึง ID ผู้ใช้
use Illuminate\Support\Facades\Storage; // เพิ่มเพื่อใช้จัดการไฟล์

class EditController extends Controller
{
    //
    public function editView($recipe_id)
    {
        $categories = DB::table('category')->get();
        $regions = DB::table('region')->get();
        $recipe = RecipeModel::with([
            'category',
            'ingredientsList',
            'region'

        ])->findOrFail($recipe_id);

        // ส่งข้อมูลไปที่ view
        return view('users.edit', compact('categories', 'regions', 'recipe'));
    }

 

    // ... ภายใน InsertRecipeController หรือ Controller ที่คุณใช้งาน

    public function update(Request $request, $recipe_id)
    {
        // 1. เริ่ม Transaction เพื่อความปลอดภัยของข้อมูล
        return DB::transaction(function () use ($request, $recipe_id) {

            // ดึงข้อมูลเดิมมาตรวจสอบ
            $recipe = DB::table('recipes')->where('recipe_id', $recipe_id)->first();
            if (!$recipe) {
                return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูลสูตรอาหาร'], 404);
            }

            $image_url = $recipe->image_url; // ใช้รูปเดิมเป็นค่าเริ่มต้น

            // 2. จัดการรูปภาพ (ถ้ามีการอัปโหลดไฟล์ใหม่เข้ามา)
            if ($request->hasFile('image')) {
                // (Optional) ลบไฟล์รูปเดิมใน Storage เพื่อประหยัดพื้นที่
                if ($recipe->image_url) {
                    $oldPath = str_replace(asset('storage/'), '', $recipe->image_url);
                    Storage::disk('public')->delete($oldPath);
                }

                // บันทึกไฟล์ใหม่
                $path = $request->file('image')->store('recipes', 'public');
                $image_url = asset('storage/' . $path);
            }

            // 3. อัปเดตตาราง recipes
            DB::table('recipes')->where('recipe_id', $recipe_id)->update([
                'title' => $request->title,
                'image_url' => $image_url,
                'description' => $request->description,
                'instructions' => $request->instructions,
                'category_id' => $request->category_id,
                'region_id' => $request->region_id,
                'updated_at' => now(),
            ]);

            // 4. จัดการตาราง recipe_ingredients (ลบของเก่าทิ้ง แล้วเพิ่มใหม่ทั้งหมด)
            DB::table('recipe_ingredients')->where('recipe_id', $recipe_id)->delete();

            $ingredients = json_decode($request->ingredients_json, true);
            if (!empty($ingredients)) {
                foreach ($ingredients as $ing) {
                    DB::table('recipe_ingredients')->insert([
                        'recipe_id' => $recipe_id,
                        'ingredient_name' => $ing['name'],
                        'amount' => $ing['amount'],
                        'unit' => $ing['unit']
                    ]);
                }
            }

            return response()->json(['success' => true]);
        });
    }

}

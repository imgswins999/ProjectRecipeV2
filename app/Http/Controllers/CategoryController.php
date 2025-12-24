<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\RecipeModel;
use App\Models\Region;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    // ของประเภทอาหาร
    public function search(Request $request)
    {
        $query = RecipeModel::query();

        // กรองตามประเภทอาหาร (ถ้ามีการเลือก)
        if ($request->filled('category_filter')) {
            $query->where('category_id', $request->category_filter);
        }

        // กรองตามประเทศ (ถ้ามีการเลือก)
        if ($request->filled('region_filter')) {
            $query->where('region_id', $request->region_filter);
        }

        $recipes = $query->with(['category', 'region'])->get();

        // ดึงข้อมูลสำหรับ Dropdown
        $categories = Category::whereHas('recipes')->get();
        $regiones = Region::whereHas('recipes')->get();

        return view('users.category', compact('recipes', 'categories', 'regiones'));
    }
}


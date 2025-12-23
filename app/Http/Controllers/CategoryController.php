<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\RecipeModel;
use App\Models\Region;
use Illuminate\Http\Request;

class CategoryController extends Controller{
   
    // ของประเภทอาหาร
    public function CategoryFilter(Request $request){
        if(request()->category_filter){
        $resultCategory = request()->category_filter;
        $recipes = RecipeModel::where('category_id', $resultCategory)->with(['category'])->get();
    }else{
        $recipes = RecipeModel::with(['category'])->get();
    }
    //ที่ต้องมีregionesเพราะ มันส่งค่าไปform แล้วหาตัวregionesในฟังค์ชั้นcategoryfilterไม่เจอจึงerror
         $regiones = Region::whereHas('recipes')->get();
        $categories = Category::whereHas('recipes')->get();

    return view('users.category', compact('recipes','categories','regiones'));

}

    public function RegionFilter(Request $request){
        if(request()->region_filter){
            $resultRegion = request()->region_filter;
            $recipes = RecipeModel::where('region_id',$resultRegion)->with(['region'])->get();
        }else{
            $recipes = RecipeModel::with('region',)->get();
        }
          $categories = Category::whereHas('recipes')->get();
        $regiones = Region::whereHas('recipes')->get();

        return view('users.category',compact('recipes','regiones','categories'));
    }
    }
        

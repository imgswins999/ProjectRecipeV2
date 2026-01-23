<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Comment; // อย่าลืม use Model
use App\Models\User;
use App\Models\RecipeModel;
use App\Models\Like;
use App\Models\RecipeView;
use Carbon\Carbon; //ใช้กำหนดเวลา



class RecipeController extends Controller
{
    //
    // SignIn Form
    public function signIn()
    {
        return view('users.signIn');
    }
    public function signInPost(Request $request)
    {

        $request->validate([
            'login' => 'required',       // เปลี่ยนชื่อ field เป็น login ตัวเดียว รองรับทั้ง 2 แบบ
            'password' => 'required'
        ]);

        // เช็คว่าเป็น email หรือ username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {

            return redirect()->route('recipe');
        }

        return back()->with("error", "Username or email or password is incorrect.");
    }

    //SignUp Form
    public function signUp()
    {
        return view('users.signUp');
    }
    public function signUpPost(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // ต้องมี password_confirmation
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // hash password
        ]);

        Auth::login($user);
        return redirect()->route('signIn');
    }


    public function logout(Request $request)
    {
        Auth::logout(); // 1. เอา User ออกจากระบบ

        $request->session()->invalidate(); // 2. เคลียร์ Session เก่า
        $request->session()->regenerateToken(); // 3. สร้าง Token ใหม่ป้องกัน CSRF

        return redirect()->route('home'); // 4. ส่งกลับไปหน้าแรก
    }
    //หน้าrecipe
    public function recipe()
    {

        // 1. New Update: เรียงตามวันที่สร้างล่าสุด (created_at)
        $newRecipes = RecipeModel::with('user')
            ->withCount('likers')
            ->latest() // หรือ orderBy('created_at', 'desc')
            ->take(5)  // เอาแค่ 5 อัน
            ->get();

        // 2. Popular: เรียงตามยอดวิว (view_count)
        $popularRecipes = RecipeModel::with('user')
            ->withCount('likers')
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        // 3. Most Like: เรียงตามจำนวนไลก์ (likers_count)
        $mostLikedRecipes = RecipeModel::with('user')
            ->withCount('likers')
            ->orderBy('likers_count', 'desc') // เรียงจากคอลัมน์นับจำนวนที่ได้จาก withCount
            ->take(5)
            ->get();
        // 4. ดึงมาทั้งหมด
        $allRecipes = RecipeModel::with('user')
            ->get();
        // ส่งตัวแปรทั้ง 3 ตัวไปหน้า View
        return view('users.recipe', compact('newRecipes', 'popularRecipes', 'mostLikedRecipes', 'allRecipes'));
    }

    public function detailfood($recipe_id)
    {
        $recipe = RecipeModel::with([
            'category',
            'ingredientsList',
            'comments' => function ($query) {
                // ดึงเฉพาะคอมเมนต์หลัก (ที่ไม่มีพ่อ)
                $query->whereNull('parent_id')
                    ->orderBy('created_at', 'desc')
                    // และดึงลูกๆ ของมันมาด้วย (ซ้อนกัน)
                    ->with('replies.user');
            },
            'comments.user' // ดึง user ของคอมเมนต์หลัก
        ])->findOrFail($recipe_id);

        // A. บันทึกในตาราง recipe_views (สำหรับการนับยอดวิวรายวัน/รายเดือน)
        $recipe->views()->create([
            'viewed_at' => Carbon::now(), // บันทึกวันที่และเวลาปัจจุบัน
        ]);

        // B. เพิ่มยอดวิวสะสมในคอลัมน์ view_count ของตาราง recipes (สำหรับ All-Time Popular)
        $recipe->increment('view_count');

        // --- เพิ่มส่วนประวัติการเข้าชมตรงนี้ ---
        if (Auth::check()) {
            // ใช้ updateOrInsert เพื่อให้สูตรที่เคยดูแล้วเด้งขึ้นมาล่าสุด (ไม่เก็บซ้ำซ้อน)
            \DB::table('viewhistory')->updateOrInsert(
                ['user_id' => Auth::id(), 'recipe_id' => $recipe_id],
                ['viewed_at' => Carbon::now()]
            );
        }
        // ----------------------------------


        return view('users.detail', compact('recipe', ));


    }

    //ทำไลค์
    public function like($recipe_id)
    {
        // 1. ตรวจสอบผู้ใช้
        $user = Auth::user();

        // 1.1 ถ้าไม่ได้ล็อกอิน ให้ Redirect ไปหน้าล็อกอิน/home
        if (!$user) {
            // ใช้ route('signIn') แทน route('recipe') ตามชื่อ Route ของคุณ
            return redirect()->route('signIn')->with('error', 'กรุณาเข้าสู่ระบบก่อนกดไลค์');
        }

        // 2. หา Recipe ตาม ID
        $recipe = RecipeModel::findOrFail($recipe_id);

        // 3. เช็คสถานะการไลค์ (ใช้ Query Builder โดยตรงเพื่อให้ง่ายต่อการ delete)
        $isLiked = Like::where('user_id', $user->user_id)
            ->where('recipe_id', $recipe->recipe_id)
            ->exists();

        if ($isLiked) {
            // 4. ถ้าไลค์แล้ว: ลบรายการไลค์ (Unlike)
            Like::where('user_id', $user->user_id)
                ->where('recipe_id', $recipe->recipe_id)
                ->delete();
        } else {
            // 5. ถ้ายังไม่ไลค์: สร้างรายการไลค์ใหม่ (Like)
            // ส่งค่า Foreign Key ทั้งสองตัวอย่างชัดเจนเพื่อป้องกัน Error
            Like::create([
                'user_id' => $user->user_id,
                'recipe_id' => $recipe->recipe_id
            ]);
        }
        // 6. Redirect กลับไปยังหน้าที่ผู้ใช้เพิ่งกด
        return back();
    }
    public function storeComment(Request $request, $recipe_id)
    {
        // 1. ตรวจสอบข้อมูล
        $request->validate([
            'comment_text' => 'required|string|max:1000',
        ]);

        // 2. บันทึกข้อมูล
        Comment::create([
            'user_id' => auth()->id(), // เอา ID คนล็อกอินปัจจุบัน
            'recipe_id' => $recipe_id,
            'comment_text' => $request->comment_text,
            'parent_id' => $request->input('parent_id') // ถ้ามีค่าส่งมาจะเป็น Reply, ถ้าไม่มีจะเป็น NULL
        ]);

        // 3. กลับไปหน้าเดิม
        return back()->with('success', 'คอมเมนต์เรียบร้อยแล้ว');
    }

    //ฟังค์ชั่นค้นหา
    public function serchRecipe(Request $request)
    {
        $keyword = $request->keyword;

        if (strlen($keyword) > 0) {
            $keyword_wildcard = "%{$keyword}%";

            // สร้าง Query หลักเก็บไว้ก่อน จะได้ไม่ต้องเขียนซ้ำหลายรอบ (ลดโค้ดซ้ำซ้อน)
            $queryBuilder = RecipeModel::where(function ($query) use ($keyword_wildcard) {
                $query->where('title', 'LIKE', $keyword_wildcard)
                    // ค้นหาจากชื่อหมวดหมู่ (ข้ามไปตาราง category)
                    ->orWhereHas('category', function ($q) use ($keyword_wildcard) {
                        $q->where('category_name', 'LIKE', $keyword_wildcard);
                    })
                    // ค้นหาจากชื่อภาค (ข้ามไปตาราง region)
                    ->orWhereHas('region', function ($q) use ($keyword_wildcard) {
                        $q->where('region_name', 'LIKE', $keyword_wildcard);
                    });
            });

            // ดึงข้อมูลตามเงื่อนไขต่างๆ โดยใช้ Query ตัวเดิม
            $newRecipes = (clone $queryBuilder)->latest()->paginate(5); // เมนูใหม่
            $popularRecipes = (clone $queryBuilder)->orderBy('view_count', 'desc')->paginate(5); // ยอดนิยม (ดูจากวิว)
            $mostLikedRecipes = (clone $queryBuilder)->withCount('likes')->orderBy('likes_count', 'desc')->paginate(5); // คนชอบเยอะ (ต้องมี relation likes)
            $allRecipes = (clone $queryBuilder)->paginate(10); // ทั้งหมด

        } else {
            return redirect()->route('signIn')->with('error', 'ไม่พบสูตรอาหาร');
        }

        return view('users.recipe', compact('newRecipes', 'keyword', 'popularRecipes', 'mostLikedRecipes', 'allRecipes'));
    }
    // RecipeController.php




}

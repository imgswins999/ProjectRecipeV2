<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\RecipeModel;



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

        // ส่งตัวแปรทั้ง 3 ตัวไปหน้า View
        return view('users.recipe', compact('newRecipes', 'popularRecipes', 'mostLikedRecipes'));
    }

    public function detailfood($recipe_id)
    {
        $recipe = RecipeModel::findOrfail($recipe_id);
        //เพิ่มยอด view_count ทุกครั้งที่มีคนกดเข้ามาดู
        $recipe->increment('view_count');
        //ส่งข้อมูลไปที่หน้า View
        return view('users.detail', compact('recipe'));


    }



}

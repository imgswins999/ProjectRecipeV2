<?php

namespace App\Http\Controllers;

use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class RecipeController extends Controller
{
    //
    // SignIn Form
    public function signIn(){
        return view('users.signIn');
    }
    public function signInPost(Request $request){

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

    if(Auth::attempt($credentials)){
        return redirect()->intended(route('page'));
    }

    return back()->with("error","username or email หรือ password ไม่ถูกต้อง");
}

    //SignUp Form
    public function signUp(){
        return view('users.signUp');
    } 
    public function signUpPost(Request $request){
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
        return redirect()->route('page');
    }

    public function recipe(){
        return view('users.recipe');
    }

    public function page(){
    return view('users.page');
}
     
}

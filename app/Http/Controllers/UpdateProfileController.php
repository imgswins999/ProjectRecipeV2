<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // หรือชื่อ Model ที่คุณใช้เชื่อมตาราง users

class UpdateProfileController extends Controller
{
    //
    public function updateProfile(Request $request)
{
    // ดึงข้อมูล User คนปัจจุบันที่กำลังล็อกอิน
    $user = User::find(Auth::id()); 

    // 1. ตรวจสอบข้อมูล (Validation)
    $request->validate([
        'display_name' => 'required|string|max:100',
        // เช็คอีเมลซ้ำ (ต้องระบุ user_id เพื่อยกเว้นตัวเอง ไม่เช่นนั้นจะฟ้องว่าอีเมลซ้ำกับตัวเอง)
        'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id', 
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // รับไฟล์รูป ไม่เกิน 2MB
        'password' => 'nullable|min:6', // รหัสผ่าน (ถ้ามีต้องอย่างน้อย 6 ตัว)
        'bio' => 'nullable|string'
    ]);

    // 2. อัพเดทข้อมูลทั่วไป
    $user->display_name = $request->display_name;
    $user->email = $request->email;
    $user->bio = $request->bio;

    // 3. จัดการเรื่องรหัสผ่าน (ถ้ามีการกรอกมาใหม่)
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // 4. จัดการเรื่องรูปภาพ (ถ้ามีการอัพโหลด)
    if ($request->hasFile('profile_image')) {
        // ตั้งชื่อไฟล์ใหม่เพื่อไม่ให้ซ้ำ (ใช้เวลาปัจจุบัน + ชื่อไฟล์เดิม)
        $file = $request->file('profile_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        
        // บันทึกไฟล์ไปที่โฟลเดอร์ public/uploads/profiles
        $file->move(public_path('uploads/profiles'), $filename);

        // บันทึก URL ลงฐานข้อมูล
        $user->profile_image_url = url('uploads/profiles/' . $filename);
    }

    // 5. บันทึกข้อมูลทั้งหมดลงฐานข้อมูล
    $user->save();

    // 6. ส่งกลับหน้าเดิมพร้อมข้อความแจ้งเตือน
    return redirect()->back()->with('success', 'อัพเดทข้อมูลส่วนตัวเรียบร้อยแล้ว');
}
}

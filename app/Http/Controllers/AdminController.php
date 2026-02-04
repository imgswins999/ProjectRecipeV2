<?php

namespace App\Http\Controllers;

use App\Models\RecipeModel;
use App\Models\User;
use App\Models\Comment;
use App\Models\History;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;


class AdminController extends Controller
{
    //
    public function index()
    {
        // ดึงข้อมูล User ที่ไม่ใช่ Admin มาแสดง
        $users = User::where('role', '!=', 'admin')->get();

        // ดึงสูตรอาหารทั้งหมด
        $recipes = RecipeModel::with('user')->get();

        return view('admins.admin', compact('users', 'recipes'));
    }

    // 1. ฟังก์ชันลบผู้ใช้งาน
    public function destroyUser($id)
    {
        // ค้นหาและลบ User
        $user = User::findOrFail($id);

        // Comments เป็นสิ่งที่ User สร้างเอง (HasMany) -> ลบทิ้งได้เลย ใช้ delete() ถูกแล้ว
        $user->comments()->delete();

        // Likes เป็นการเชื่อมโยงกับสูตรอาหาร (BelongsToMany) 
        // ใช้ detach() เพื่อ "เอาการกด Like ออก" (อย่าใช้ delete เพราะมันจะไปลบสูตรอาหาร)
        $user->likes()->detach();

        // *** จุดที่ต้องระวังเพิ่ม ***
        // followers และ followings ก็น่าจะเป็น Many-to-Many เหมือนกัน
        // ถ้าใช้ delete() มันอาจจะไปลบ Account ของ User คนอื่นที่มาติดตามเราทิ้งไปด้วย!
        // แนะนำให้เปลี่ยนเป็น detach() เพื่อความปลอดภัยครับ
        $user->followers()->detach();
        $user->followings()->detach();

        // สุดท้ายค่อยลบ User
        $user->delete();

        // ส่งกลับหน้าเดิมพร้อมข้อความแจ้งเตือน
        return back()->with('success', 'ลบบัญชีผู้ใช้งานเรียบร้อยแล้ว');
    }

    // 2. ฟังก์ชันลบสูตรอาหาร
    public function destroyRecipe($id)
    {
        // ค้นหาและลบ Recipe
        $recipe = RecipeModel::findOrFail($id);
        $recipe->comments()->delete();
        $recipe->likes()->delete();
        $recipe->views()->delete();
        $recipe->viewHistory()->delete();
        $recipe->delete();

        return back()->with('success', 'ลบสูตรอาหารเรียบร้อยแล้ว');
    }

    public function notifyUser($user_id)
    {
        // ตรวจสอบว่ามี User นี้อยู่จริงไหม
        $user = User::findOrFail($user_id);

        // บันทึกลงฐานข้อมูลตาราง notifications
        // หมายเหตุ: ตาม SQL ที่ให้มา ตาราง notifications ไม่มีช่องเก็บข้อความ (message)
        // เราจึงใช้ 'notification_type' เป็นตัวบอกว่าเป็น 'warning' แทน
        DB::table('notifications')->insert([
            'recipient_id' => $user_id,         // ส่งถึงใคร
            'sender_id' => Auth::id(),          // ใครเป็นคนส่ง (Admin ที่ล็อกอินอยู่)
            'notification_type' => 'warning',   // กำหนดประเภทเป็น "แจ้งเตือน/ตักเตือน"
            'related_recipe_id' => null,        // ไม่ได้เกี่ยวกับสูตรไหนเป็นพิเศษ (เตือนเรื่องพฤติกรรม)
            'is_read' => 0,                     // ยังไม่เปิดอ่าน
            'created_at' => now(),              // เวลาปัจจุบัน
        ]);

        return back()->with('success', 'ส่งการแจ้งเตือนไปยังผู้ใช้งานเรียบร้อยแล้ว');
    }
}

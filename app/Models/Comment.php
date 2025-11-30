<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //

    protected $table = 'comments'; // ชื่อตารางของคุณ
    protected $primaryKey = 'comment_id'; // ชื่อ Primary Key
    public $timestamps = false;
    // ✅ เพิ่มส่วนนี้ลงไปเพื่ออนุญาตให้บันทึกข้อมูลเหล่านี้ได้
    protected $fillable = [
        'user_id',
        'recipe_id',
        'comment_text',
        'parent_id',
        'is_hidden'
    ];
    public function user()
    {
        // เชื่อมกับตาราง users เพื่อดึงชื่อและรูป
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function replies()
    {
        // เชื่อมกับตัวเอง โดยหา record ที่มี parent_id ตรงกับ comment_id ของตัวนี้
        return $this->hasMany(Comment::class, 'parent_id', 'comment_id')
            ->with('user') // ดึงข้อมูลคนตอบกลับมาด้วย
            ->orderBy('created_at', 'asc'); // เรียงจากเก่าไปใหม่ (ใครตอบก่อนขึ้นก่อน)
    }
}

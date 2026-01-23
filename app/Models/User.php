<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. ระบุชื่อตารางให้ชัดเจน
    protected $table = 'users';

    // 🔥 2. ระบุ Primary Key ให้ตรงกับฐานข้อมูล (สำคัญมาก!)
    protected $primaryKey = 'user_id';

    // 🔥 3. ปิด Timestamps อัตโนมัติ เพราะตาราง users คุณไม่มี updated_at
    public $timestamps = false;

    // ถ้าต้องการใช้แค่ created_at อย่างเดียว ให้เปิดบรรทัดล่างนี้แทน
    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = null;

    protected $fillable = [
        'username',
        'email',
        'password',
        'display_name', // เพิ่มตาม DB
        'bio',          // เพิ่มตาม DB
        'profile_image_url',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ความสัมพันธ์กับ Recipe
    public function recipes()
    {
        // user_id แรกคือ FK ในตาราง recipes
        // user_id ที่สองคือ PK ในตาราง users
        return $this->hasMany(RecipeModel::class, 'user_id', 'user_id');
    }

    //ความสัมพันธ์กับ like
    public function likes()
    {
        return $this->belongsToMany(RecipeModel::class, 'likes', 'user_id', 'recipe_id');
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->withPivot('created_at');
    }
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
            ->withPivot('created_at');
    }

    // 1. กดติดตาม
    public function follow(User $user)
    {
        // เช็คก่อนว่าตัวเองไม่ได้กดติดตามตัวเอง และยังไม่ได้ติดตามคนนี้
        if ($this->user_id !== $user->user_id && !$this->isFollowing($user)) {
            $this->followings()->attach($user->user_id);
            return true;
        }
        return false;
    }

    // 2. ยกเลิกการติดตาม
    public function unfollow(User $user)
    {
        $this->followings()->detach($user->user_id);
        return true;
    }

    // 3. เช็คสถานะว่าติดตามคนนี้อยู่หรือไม่
    public function isFollowing(User $user)
    {
        return $this->followings()->where('following_id', $user->user_id)->exists();
    }

}
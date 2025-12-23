<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\User;


class RecipeModel extends Model
{
    //
    public $timestamps = false;
    use HasFactory;
    protected $table = 'recipes';


    protected $fillable = [
        'title',
        'description',
        'image_url',
        'region'
    ];
    protected $primaryKey = 'recipe_id';
    public function user()
    {
        /**
         * บอกว่า Model นี้ "เป็นของ" (belongsTo) User::class
         * โดยเชื่อมจากคอลัมน์ 'user_id' (ในตาราง recipes)
         * ไปยังคอลัมน์ 'user_id' (ในตาราง users)
         */
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function likers()
    {


        // ✅ โค้ดใหม่ (ระบุ Key ให้ครบ):
        return $this->belongsToMany(
            User::class,
            'likes',      // 1. ตารางกลาง (Pivot)
            'recipe_id',  // 2. Foreign Key ของ Recipe ในตาราง 'likes'
            'user_id',    // 3. Foreign Key ของ User ในตาราง 'likes'
            'recipe_id',  // 4. Primary Key ของ Model ปัจจุบัน (RecipeModel)
            'user_id'     // 5. Primary Key ของ Model ที่มาเชื่อม (User)
        );
    }

    public function ingredientsList()
    {
        return $this->hasMany(RecipeIngredient::class, 'recipe_id', 'recipe_id');
    }

    //ทำไลค์
    public function likes()
    {
        return $this->hasMany(Like::class, 'recipe_id', 'recipe_id');
    }
    //เพื่อตรวจสอบว่าผู้ใช้ปัจจุบันไลค์เมนูอาหารนี้หรือไม่
    public function isLikedBy(?User $user)
    {
        if ($user === null) {
            return false;
        }
        return $this->likes()->where('user_id', $user->user_id)->exists();
    }

    public function comments()
    {
        // เชื่อมกับตาราง comments และกรองเฉพาะที่ไม่ซ่อน + เรียงจากใหม่ไปเก่า
        return $this->hasMany(Comment::class, 'recipe_id', 'recipe_id')
            ->where('is_hidden', 0)
            ->orderBy('created_at', 'desc');
    }
    //กำหนดความสัมพันธ์forekey ให้ตัวสูตรอาหารมียอดวิวได้หลายครั้ง
    public function views()
    {
        return $this->hasMany(RecipeView::class,'recipe_id','recipe_id');
    }

        public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function region()
        {
            return $this->belongsTo(Region::class,'region_id','region_id');
        }
    
}

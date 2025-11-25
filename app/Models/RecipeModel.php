<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'meal_type',
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

}

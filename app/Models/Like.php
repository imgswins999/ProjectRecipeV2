<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    public $timestamps = false;
    protected $table = 'likes';
    protected $fillable =['user_id','recipe_id'];

    public function recipe()
    {
        // ไลค์หนึ่งอันเป็นของเมนูอันเดียว
        return $this->belongsTo(RecipeModel::class); 
    }

    public function user()
    {
        // ไลค์หนึ่งอันเป็นของผู้ใช้หนึ่งคน
        return $this->belongsTo(User::class);
    }
}
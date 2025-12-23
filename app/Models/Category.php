<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{

    protected $table = 'category'; // ชื่อตารางของคุณ
    protected $primaryKey = 'category_id'; // ชื่อ Primary Key
    public $timestamps = false;
     
     protected $fillable = [
        'category_name',
    ];
    public function recipes()
    {
        return $this->hasMany(RecipeModel::class, 'category_id', 'category_id');
    }

}
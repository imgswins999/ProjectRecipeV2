<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model{

    protected $table = 'region'; // ชื่อตารางของคุณ
    protected $primaryKey = 'region_id'; // ชื่อ Primary Key
    public $timestamps = false;
     
     protected $fillable = [
        'region_name',
    ];
    public function recipes()
    {
        return $this->hasMany(RecipeModel::class, 'region_id', 'region_id');
    }

}
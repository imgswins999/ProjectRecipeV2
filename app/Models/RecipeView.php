<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeView extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'recipe_views';

    protected $fillable = [
        'recipe_id',
        'viewed_at',
    ];

    //เอาไว้กำหนดforeign key
     public function recipe()
    {
        // ไลค์หนึ่งอันเป็นของเมนูอันเดียว
        return $this->belongsTo(RecipeModel::class); 
    }
}

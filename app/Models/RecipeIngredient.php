<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    //
    protected $table = 'recipe_ingredients';
    protected $primaryKey = 'recipe_ingredient_id';
    public $timestamps = false; // ถ้าตารางไม่มี created_at/updated_at
}

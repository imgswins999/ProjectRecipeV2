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
    
    protected $fillable =[
    'title',
    'description',
    'image_url',
    'meal_type',
    'region'
    ];
}

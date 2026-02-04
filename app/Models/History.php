<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    //
    use HasFactory;
    public $timestamps = false;
    protected $table = 'viewhistory';
    protected $primaryKey = 'history_id';

    protected $fillable = [
        'user_id',
        'recipe_id',
        'viewed_at'
    ];

    //เอาไว้กำหนดforeign key
    public function recipe()
    {
        // ไลค์หนึ่งอันเป็นของเมนูอันเดียว
        return $this->belongsTo(RecipeModel::class, 'recipe_id', 'recipe_id');
    }

    //เอาไว้กำหนดforeign key
    public function user()
    {
        // ไลค์หนึ่งอันเป็นของเมนูอันเดียว
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Like;
use App\Models\User;


class FollowModel extends Model
{
    public $timestamps = false;
    protected $table = 'follows';
    protected $fillable = ['follower_id ', 'following_id','created_at'];
    public function user()
    {
        // ไลค์หนึ่งอันเป็นของผู้ใช้หนึ่งคน
        return $this->belongsTo(User::class);
    }
}

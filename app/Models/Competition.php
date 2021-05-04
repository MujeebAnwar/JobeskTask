<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
    ];
    public function userVideos()
    {
        return $this->belongsToMany(Video::class,'competition_video','competition_id','video_id')
            ->where('user_id','<>',auth()->id());
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class,'competition_video','competition_id','video_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;


    public $dir ='/videosFiles/';

    protected $fillable = [
        'name',
        'video_path',
        'user_id',
        'competition'
    ];

    public function getVideoPathAttribute($path)
    {
        return asset($this->dir).'/'.$path;

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}


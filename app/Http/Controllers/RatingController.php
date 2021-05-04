<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    //


    public function competitionVideosRating(Request $request)
    {
        Rating::updateOrCreate([
            'user_id'   =>auth()->id(),
            'video_id' => $request->video_id,
        ],[
            'rating'     => $request->rating,

        ]);
        dd($request->all());
    }
}
